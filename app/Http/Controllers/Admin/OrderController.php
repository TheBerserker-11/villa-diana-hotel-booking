<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\AdminActivityLog;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminBookingsExport;
use App\Exports\ReferenceExport;

use App\Mail\BookingStatusMail;

class OrderController extends Controller
{
    /**
     * ADMIN: Booking list (with search + filter + pagination)
     * ✅ Shows ALL bookings (pending + confirmed + cancelled)
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $filterCode = trim((string) $request->input('reference_code', ''));
        $statusFilter = trim((string) $request->input('status_filter', ''));
        $roomTypeFilter = (int) $request->input('room_type_id', 0);
        $checkInFrom = trim((string) $request->input('check_in_from', ''));
        $checkInTo = trim((string) $request->input('check_in_to', ''));
        if ($filterCode === 'all') {
            $filterCode = '';
        }

        $orders = $this->buildFilteredOrdersQuery(
            $search,
            $filterCode,
            $statusFilter,
            $roomTypeFilter,
            $checkInFrom,
            $checkInTo
        )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $duplicateCodes = Order::select('reference_code')
            ->whereNotNull('reference_code')
            ->groupBy('reference_code')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('reference_code')
            ->toArray();

        $referencestats = Order::select('reference_code')
            ->selectRaw('COUNT(*) as total')
            ->whereNotNull('reference_code')
            ->groupBy('reference_code')
            ->get();

        $roomTypes = RoomType::select('id', 'name')->orderBy('name')->get();

        return view('admin.bookings.index', [
            'orders'         => $orders,
            'search'         => $search,
            'filterCode'     => $filterCode,
            'statusFilter'   => $statusFilter,
            'roomTypeFilter' => $roomTypeFilter,
            'checkInFrom'    => $checkInFrom,
            'checkInTo'      => $checkInTo,
            'referencestats' => $referencestats,
            'roomTypes'      => $roomTypes,
            'duplicateCodes' => $duplicateCodes,
            'adminView'      => true,
        ]);
    }

    /**
     * ADMIN: Live data (optional polling)
     * ✅ Returns ALL bookings
     */
    public function liveData(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $filterCode = trim((string) $request->input('reference_code', ''));
        $statusFilter = trim((string) $request->input('status_filter', ''));
        $roomTypeFilter = (int) $request->input('room_type_id', 0);
        $checkInFrom = trim((string) $request->input('check_in_from', ''));
        $checkInTo = trim((string) $request->input('check_in_to', ''));
        if ($filterCode === 'all') {
            $filterCode = '';
        }

        $orders = $this->buildFilteredOrdersQuery(
            $search,
            $filterCode,
            $statusFilter,
            $roomTypeFilter,
            $checkInFrom,
            $checkInTo
        )
            ->orderByDesc('created_at')
            ->get();

        return response()->json($orders);
    }

    public function exportBookings(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $filterCode = trim((string) $request->input('reference_code', ''));
        $statusFilter = trim((string) $request->input('status_filter', ''));
        $roomTypeFilter = (int) $request->input('room_type_id', 0);
        $checkInFrom = trim((string) $request->input('check_in_from', ''));
        $checkInTo = trim((string) $request->input('check_in_to', ''));
        if ($filterCode === 'all') {
            $filterCode = '';
        }

        $filename = 'admin_bookings_' . now()->format('Ymd_His') . '.xlsx';

        return Excel::download(
            new AdminBookingsExport(
                $search,
                $filterCode,
                $statusFilter,
                $roomTypeFilter,
                $checkInFrom,
                $checkInTo
            ),
            $filename
        );
    }

    /**
     * ADMIN: Update status (pending -> confirmed/cancelled)
     */
    public function update(Request $request, Order $order)
    {
        $wantsJson = $request->expectsJson() || $request->wantsJson() || $request->ajax();

        $request->validate([
            'status'        => 'required|in:confirmed,cancelled',
            'cancel_reason' => 'required_if:status,cancelled|max:5000',
        ]);

        $result = DB::transaction(function () use ($request, $order) {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->first();

            if (!$lockedOrder || strtolower((string) ($lockedOrder->status ?? 'pending')) !== 'pending') {
                return [
                    'already_decided' => true,
                    'order' => $lockedOrder,
                    'overlapping' => collect(),
                ];
            }

            if ($request->status === 'confirmed') {
                $lockedOrder->update([
                    'status' => 'confirmed',
                    'cancel_reason' => null,
                ]);

                $overlapping = Order::where('id', '!=', $lockedOrder->id)
                    ->where('room_id', $lockedOrder->room_id)
                    ->where('status', 'pending')
                    ->where('check_in', '<', $lockedOrder->check_out)
                    ->where('check_out', '>', $lockedOrder->check_in)
                    ->lockForUpdate()
                    ->get();

                foreach ($overlapping as $overlapOrder) {
                    $overlapOrder->update([
                        'status' => 'cancelled',
                        'cancel_reason' => 'Auto-cancelled: room was confirmed for another booking.',
                    ]);
                }

                return [
                    'already_decided' => false,
                    'order' => $lockedOrder->fresh(['user']),
                    'overlapping' => $overlapping,
                ];
            }

            $lockedOrder->update([
                'status' => 'cancelled',
                'cancel_reason' => (string) $request->cancel_reason,
            ]);

            return [
                'already_decided' => false,
                'order' => $lockedOrder->fresh(['user']),
                'overlapping' => collect(),
            ];
        });

        if (!empty($result['already_decided'])) {
            $message = 'This booking was already decided and cannot be edited.';
            if ($wantsJson) {
                return response()->json(['message' => $message], 422);
            }

            return back()->with('message', $message);
        }

        /** @var \App\Models\Order $updatedOrder */
        $updatedOrder = $result['order'];
        $overlapping = collect($result['overlapping'] ?? []);

        if ($updatedOrder->status === 'confirmed') {
            if ($updatedOrder->user && $updatedOrder->user->email) {
                Mail::to($updatedOrder->user->email)->send(new BookingStatusMail($updatedOrder));
            }

            foreach ($overlapping as $overlapOrder) {
                if ($overlapOrder->user && $overlapOrder->user->email) {
                    Mail::to($overlapOrder->user->email)->send(new BookingStatusMail($overlapOrder));
                }
            }

            AdminActivityLog::record(
                $request->user(),
                'confirm_booking',
                'Order',
                $updatedOrder->id,
                [
                    'reference_code' => $updatedOrder->reference_code,
                    'auto_cancelled_count' => $overlapping->count(),
                ]
            );

            $message = 'Booking confirmed. Conflicting pending bookings were auto-cancelled.';
            if ($wantsJson) {
                $autoCancelledOrders = $overlapping->map(function ($o) {
                    return [
                        'id' => $o->id,
                        'status' => $o->status,
                        'cancel_reason' => $o->cancel_reason,
                    ];
                })->values();

                return response()->json([
                    'message' => $message,
                    'order' => [
                        'id' => $updatedOrder->id,
                        'status' => $updatedOrder->status,
                        'cancel_reason' => $updatedOrder->cancel_reason,
                    ],
                    'meta' => [
                        'auto_cancelled_count' => $overlapping->count(),
                        'auto_cancelled_orders' => $autoCancelledOrders,
                    ],
                ]);
            }

            return back()->with('message', $message);
        }

        if ($updatedOrder->user && $updatedOrder->user->email) {
            Mail::to($updatedOrder->user->email)->send(new BookingStatusMail($updatedOrder));
        }

        AdminActivityLog::record(
            $request->user(),
            'cancel_booking',
            'Order',
            $updatedOrder->id,
            [
                'reference_code' => $updatedOrder->reference_code,
                'cancel_reason' => $updatedOrder->cancel_reason,
            ]
        );

        $message = 'Booking cancelled with reason and email sent.';
        if ($wantsJson) {
            return response()->json([
                'message' => $message,
                'order' => [
                    'id' => $updatedOrder->id,
                    'status' => $updatedOrder->status,
                    'cancel_reason' => $updatedOrder->cancel_reason,
                ],
            ]);
        }

        return back()->with('message', $message);
    }

    /**
     * ADMIN: Reference analytics
     */
    public function referenceAnalytics()
    {
        $leaderboard = Order::select('reference_code')
            ->selectRaw('COUNT(*) as total_bookings')
            ->whereNotNull('reference_code')
            ->groupBy('reference_code')
            ->orderByDesc('total_bookings')
            ->get();

        $duplicateCodes = Order::select('reference_code')
            ->whereNotNull('reference_code')
            ->groupBy('reference_code')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('reference_code')
            ->toArray();

        $top5 = $leaderboard->take(5);

        return view('admin.references.index', [
            'leaderboard'    => $leaderboard,
            'duplicateCodes' => $duplicateCodes,
            'top5'           => $top5,
            'adminView'      => true,
        ]);
    }

    public function exportReferences()
    {
        return Excel::download(new ReferenceExport, 'references.xlsx');
    }

    private function buildFilteredOrdersQuery(
        string $search = '',
        string $filterCode = '',
        string $statusFilter = '',
        int $roomTypeFilter = 0,
        string $checkInFrom = '',
        string $checkInTo = ''
    )
    {
        $query = Order::with(['user', 'room.roomtype']);

        if ($search !== '') {
            $query->where(function ($main) use ($search) {
                $main->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('phone', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhere('reference_code', 'LIKE', "%{$search}%");
            });
        }

        if ($filterCode !== '') {
            $query->where('reference_code', $filterCode);
        }

        if (in_array($statusFilter, ['pending', 'confirmed', 'cancelled'], true)) {
            $query->where('status', $statusFilter);
        }

        if ($roomTypeFilter > 0) {
            $query->whereHas('room', function ($roomQuery) use ($roomTypeFilter) {
                $roomQuery->where('room_type_id', $roomTypeFilter);
            });
        }

        if ($checkInFrom !== '') {
            $query->whereDate('check_in', '>=', $checkInFrom);
        }

        if ($checkInTo !== '') {
            $query->whereDate('check_in', '<=', $checkInTo);
        }

        return $query;
    }
}
