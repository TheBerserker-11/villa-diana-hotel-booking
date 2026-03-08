<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAnalyticsService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request, AdminAnalyticsService $analytics)
    {
        $data = $analytics->build($request->all());

        return view('admin.report.index', $data);
    }

    public function exportReportPdf(Request $request, AdminAnalyticsService $analytics)
    {
        $data = $analytics->build($request->all());
        $data['generated_at'] = Carbon::now()->format('M d, Y h:i A');

        $pdf = \PDF::loadView('admin.report.pdf', $data)->setPaper('A4', 'portrait');

        return $pdf->download(
            "villa-diana-report-{$data['start_date']}-to-{$data['end_date']}.pdf"
        );
    }

    public function live(Request $request, AdminAnalyticsService $analytics)
    {
        $data = $analytics->build($request->all());

        return response()->json([
            'range' => [
                'period' => $data['period'],
                'periodLabel' => $data['periodLabel'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ],
            'calendar' => [
                'month' => $data['calendar_month'],
                'label' => $data['calendar_label'],
                'offset' => $data['calendar']['offset'] ?? 1,
                'days' => $data['calendar']['days'] ?? [],
                'summary' => $data['calendar']['summary'] ?? [],
            ],
            'kpis' => [
                'totalRooms' => $data['totalRooms'],
                'revenueInRange' => $data['revenueInRange'],
                'bookingsInRange' => $data['bookingsInRange'],
                'pendingInRange' => $data['pendingInRange'],
                'cancelledInRange' => $data['cancelledInRange'],
                'cancellationRate' => $data['cancellationRate'],
                'avgBookingValue' => $data['avgBookingValue'],
                'avgStayLength' => $data['avgStayLength'],
                'revPar' => $data['revPar'],
                'occupiedToday' => $data['occupiedToday'],
                'occupancyRateToday' => $data['occupancyRateToday'],
            ],
            'tables' => [
                'mostBookedRooms' => collect($data['mostBookedRooms'])->map(fn ($row) => [
                    'room_type' => $row->room?->roomType?->name ?? 'N/A',
                    'orders_count' => (int) ($row->orders_count ?? 0),
                ])->values(),
                'currentCheckIns' => collect($data['currentCheckIns'])->map(fn ($row) => [
                    'room_id' => $row->room?->id ?? 'N/A',
                    'room_type' => $row->room?->roomType?->name ?? 'N/A',
                    'guest' => trim(($row->customer?->name ?? 'N/A') . ' ' . ($row->customer?->last_name ?? '')),
                    'check_in' => $row->check_in ? Carbon::parse($row->check_in)->format('Y-m-d') : '-',
                    'check_out' => $row->check_out ? Carbon::parse($row->check_out)->format('Y-m-d') : '-',
                ])->values(),
                'leaderboard' => collect($data['leaderboard'])->map(fn ($row) => [
                    'reference_code' => $row->reference_code,
                    'total_bookings' => (int) $row->total_bookings,
                    'duplicate' => in_array($row->reference_code, ($data['duplicateCodes'] ?? []), true),
                ])->values(),
                'roomAvailabilityRows' => $data['roomAvailabilityRows'],
                'bookingTimeline' => $data['bookingTimeline'],
                'activityLogs' => collect($data['activityLogs'])->map(fn ($log) => [
                    'actor' => $log->adminUser?->name ?? 'System',
                    'action' => $log->action,
                    'target' => trim(($log->target_type ?? '') . ' #' . ($log->target_id ?? '')),
                    'created_at' => optional($log->created_at)->toIso8601String(),
                ])->values(),
            ],
            'charts' => [
                'occupancyTrend' => [
                    'labels' => $data['dates'],
                    'data' => $data['occupancyCounts'],
                    'maxY' => (int) $data['totalRooms'],
                ],
                'referenceTop5' => [
                    'labels' => collect($data['top5'])->pluck('reference_code')->values(),
                    'data' => collect($data['top5'])->pluck('total_bookings')->map(fn ($v) => (int) $v)->values(),
                ],
                'monthlyBookings' => [
                    'labels' => $data['monthlyTrendLabels'],
                    'data' => $data['monthlyTrendBookings'],
                ],
                'prediction' => [
                    'history_labels' => $data['prediction']['history_labels'] ?? [],
                    'history_bookings' => $data['prediction']['history_bookings'] ?? [],
                    'labels' => $data['prediction']['labels'] ?? [],
                    'bookings' => $data['prediction']['bookings'] ?? [],
                ],
            ],
            'prediction' => $data['prediction'],
            'generated_at' => $data['generated_at'],
        ]);
    }
}
