<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Room;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    private const EXTRA_PAX_FEE = 1200;
    private const BREAKFAST_PRICE = 550;
    private const VAT_RATE = 0.10;
    private const CAPACITY_BUCKETS = [2, 3, 6, 8, 16, 20, 22];

    public function __construct()
    {
        // summary page must be accessible to guests, so don't protect it
        $this->middleware('auth')->only(['index', 'store', 'create']);
    }

    /* ==========================
       USER BOOKINGS
    =========================== */

    public function index()
    {
        $orders = Order::with('room.roomType')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function notificationsLive(Request $request)
    {
        if (!Auth::check() || (bool) Auth::user()->is_admin) {
            return response()->json([
                'count' => 0,
                'marker' => '',
                'items' => [],
            ]);
        }

        $notifQuery = Order::with('room.roomtype')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['confirmed', 'approved', 'cancelled'])
            ->orderByDesc('updated_at');

        $count = (clone $notifQuery)->count();

        $items = $notifQuery
            ->limit(7)
            ->get()
            ->map(function (Order $notif) {
                $status = strtolower((string) ($notif->status ?? ''));
                $isApproved = in_array($status, ['confirmed', 'approved'], true);

                return [
                    'id' => (int) $notif->id,
                    'status' => $status,
                    'is_approved' => $isApproved,
                    'room_name' => (string) ($notif->room->roomtype->name ?? 'Room'),
                    'reference_code' => (string) ($notif->reference_code ?? 'N/A'),
                    'cancel_reason' => $isApproved
                        ? ''
                        : Str::limit((string) ($notif->cancel_reason ?? ''), 100),
                    'updated_human' => (string) (optional($notif->updated_at)->diffForHumans() ?? ''),
                    'updated_ts' => (int) (optional($notif->updated_at)->timestamp ?? 0),
                ];
            })
            ->values();

        $latest = $items->first();
        $marker = $count > 0
            ? implode('|', [
                (string) $count,
                (string) ($latest['id'] ?? ''),
                (string) ($latest['updated_ts'] ?? ''),
            ])
            : '';

        return response()->json([
            'count' => $count,
            'marker' => $marker,
            'items' => $items,
        ]);
    }

    /**
     * Auth-only "continue booking" route.
     * Reuses the same booking summary page.
     */
    public function create(Request $request)
    {
        return $this->summary($request);
    }

    /**
     * Public booking summary route:
     * /booking/summary?room_id=...&check_in=...&check_out=...&adults=...
     */
   public function summary(Request $request)
{
    $fields = $request->validate([
        'room_id'   => ['required', 'integer', 'exists:rooms,id'],
        'check_in'  => ['required', 'date'],
        'check_out' => ['required', 'date', 'after:check_in'],
        'adults'    => ['required', 'integer', 'min:1'],
        'children'  => ['nullable', 'integer', 'min:0'],
        'infants'   => ['nullable', 'integer', 'min:0'],
        'pets'      => ['nullable', 'integer', 'min:0'],
    ]);

    $room = Room::with(['roomtype.inclusions'])->findOrFail($fields['room_id']);

    if (Schema::hasColumn('rooms', 'status') && !$room->status) {
        return redirect()->route('rooms.index')->with('error', 'This room is not available right now.');
    }

    $totalGuests = $this->countGuests(
        (int) $fields['adults'],
        (int) ($fields['children'] ?? 0),
        (int) ($fields['infants'] ?? 0)
    );

    $nights = $this->countNights($fields['check_in'], $fields['check_out']);
    [$perNight, $extraPax] = $this->computePerNightPrice($room, $totalGuests);

    $pricing = [
        'per_night' => $perNight,
        'extra_pax' => $extraPax,
        'nights'    => $nights,
    ];

    // IMPORTANT: render the "previous look" page
    return view('orders.create', compact(
        'room',
        'fields',
        'pricing',
        'totalGuests'
    ));
}

    /* ==========================
       STORE BOOKING
       Pending + Confirmed block
       Cancelled does NOT block
    =========================== */

    public function store(Request $request)
    {
        $request->validate([
            'check_in'       => ['required', 'date'],
            'check_out'      => ['required', 'date', 'after:check_in'],
            'adults'         => ['required', 'integer', 'min:1'],
            'children'       => ['nullable', 'integer', 'min:0'],
            'infants'        => ['nullable', 'integer', 'min:0'],
            'pets'           => ['nullable', 'integer', 'min:0'],
            'breakfast_qty'  => ['nullable', 'integer', 'min:0', 'max:200'],
            'room_id'        => ['required', 'exists:rooms,id'],
            'reference_code' => ['required', 'string', 'size:13', 'unique:orders,reference_code'],
            'paid'           => ['accepted'],
            'terms'          => ['accepted'],
            'proof_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $room = Room::with('roomtype')->findOrFail($request->room_id);

        if (Schema::hasColumn('rooms', 'status') && !$room->status) {
            return back()->with('error', 'This room is not available right now.');
        }

        $checkIn  = (string) $request->check_in;
        $checkOut = (string) $request->check_out;

        $overlap = Order::where('room_id', $room->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->exists();

        if ($overlap) {
            return back()->with('error', 'Room already booked for selected dates.');
        }

        $totalGuests = $this->countGuests(
            (int) $request->adults,
            (int) ($request->children ?? 0),
            (int) ($request->infants ?? 0)
        );

        $nights = $this->countNights($checkIn, $checkOut);
        [$perNight, $extraPax] = $this->computePerNightPrice($room, $totalGuests);
        $breakfastQty = max(0, (int) $request->input('breakfast_qty', 0));
        $breakfastTotal = $breakfastQty * self::BREAKFAST_PRICE;

        $roomSubTotal = $perNight * $nights;
        $subTotal    = $roomSubTotal + $breakfastTotal;
        $vatAmount   = $subTotal * self::VAT_RATE;
        $totalAmount = $subTotal + $vatAmount;

        $payload = [
            'check_in'        => $checkIn,
            'check_out'       => $checkOut,
            'room_id'         => $room->id,
            'adults'          => (int) $request->adults,
            'children'        => (int) ($request->children ?? 0),
            'infants'         => (int) ($request->infants ?? 0),
            'pets'            => (int) ($request->pets ?? 0),
            'reference_code'  => (string) $request->reference_code,
            'status'          => 'pending',
            'total_guests'    => $totalGuests,
            'extra_pax'       => $extraPax,
            'extra_pax_fee'   => self::EXTRA_PAX_FEE,
            'price_per_night' => $perNight,
            'sub_total'       => $subTotal,
            'vat_amount'      => $vatAmount,
            'total_amount'    => $totalAmount,
            'nights'          => $nights,
        ];

        if (Schema::hasColumn('orders', 'breakfast_qty')) {
            $payload['breakfast_qty'] = $breakfastQty;
        }
        if (Schema::hasColumn('orders', 'breakfast_unit_price')) {
            $payload['breakfast_unit_price'] = self::BREAKFAST_PRICE;
        }
        if (Schema::hasColumn('orders', 'breakfast_total')) {
            $payload['breakfast_total'] = $breakfastTotal;
        }

        if ($request->hasFile('proof_image')) {
            $payload['proof_image'] = $request->file('proof_image')->store('proofs', 'public');
        }

        Auth::user()->orders()->create($payload);

        return redirect()->route('orders.index')
            ->with('success', 'Booking submitted! Please wait for confirmation.');
    }

    /* ==========================
       ROOMS LIST PAGE (PUBLIC)
    =========================== */

    public function list_rooms(Request $request)
    {
        $searched = $request->filled(['check_in', 'check_out']);

        $adults   = (int) ($request->adults ?? 1);
        $children = (int) ($request->children ?? 0);
        $infants  = (int) ($request->infants ?? 0);

        $totalGuests = $this->countGuests($adults, $children, $infants);
        $targetCapacity = $this->pickCapacityBucket($totalGuests);

        $roomsQuery = Room::with('roomtype');

        if (Schema::hasColumn('rooms', 'status')) {
            $roomsQuery->where('status', 1);
        }

        if (Schema::hasColumn('rooms', 'max_capacity')) {
            if ($searched) {
                $roomsQuery->where('max_capacity', '>=', $targetCapacity);
            }
            $roomsQuery->orderBy('max_capacity', 'asc');
        }

        if ($searched) {
            $roomsQuery->whereDoesntHave('orders', function ($q) use ($request) {
                $q->whereIn('status', ['pending', 'confirmed'])
                    ->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            });
        }

        $rooms = $roomsQuery->get();

        $rooms->each(function ($room) use ($totalGuests) {
            [$perNight, $extraPax] = $this->computePerNightPrice($room, $totalGuests);
            $room->computed_total_per_night = $perNight;
            $room->computed_extra_pax = $extraPax;
            $room->computed_total_guests = $totalGuests;
        });

        $reviews = Review::latest()->take(10)->get();

        return view('pages.rooms', compact(
            'rooms',
            'searched',
            'reviews',
            'totalGuests',
            'targetCapacity'
        ));
    }

    /* ==========================
       HELPERS
    =========================== */

    private function countGuests(int $adults, int $children, int $infants): int
    {
        return max(1, $adults + $children + $infants);
    }

    private function pickCapacityBucket(int $guests): int
    {
        foreach (self::CAPACITY_BUCKETS as $cap) {
            if ($guests <= $cap) return $cap;
        }
        return end(self::CAPACITY_BUCKETS);
    }

    private function countNights(string $checkIn, string $checkOut): int
    {
        $in = Carbon::parse($checkIn)->startOfDay();
        $out = Carbon::parse($checkOut)->startOfDay();
        return max(1, $in->diffInDays($out));
    }

    private function computePerNightPrice(Room $room, int $guests): array
    {
        $base = (float) $room->price;

        $included = Schema::hasColumn('rooms', 'included_pax')
            ? (int) $room->included_pax
            : 1;

        $extraPax = max(0, $guests - $included);
        $perNight = $base + ($extraPax * self::EXTRA_PAX_FEE);

        return [$perNight, $extraPax];
    }
}
