<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminAnalyticsService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request, AdminAnalyticsService $analytics)
    {
        $data = $analytics->build($request->all());

        return view('admin.index', $data);
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
                'totalBeds' => $data['totalBeds'],
                'reservedRooms' => $data['reservedRooms'],
                'availableRooms' => $data['availableRooms'],
                'upcomingCheckins' => $data['upcomingCheckins'],
                'occupancyRateToday' => $data['occupancyRateToday'],
                'occupiedToday' => $data['occupiedToday'],
                'revenueToday' => $data['revenueToday'],
                'revenueInRange' => $data['revenueInRange'],
                'bookingsInRange' => $data['bookingsInRange'],
                'pendingInRange' => $data['pendingInRange'],
                'cancelledInRange' => $data['cancelledInRange'],
                'cancellationRate' => $data['cancellationRate'],
                'avgBookingValue' => $data['avgBookingValue'],
                'avgStayLength' => $data['avgStayLength'],
                'revPar' => $data['revPar'],
            ],
            'charts' => [
                'occupancyTrend' => [
                    'labels' => $data['dates'],
                    'data' => $data['occupancyCounts'],
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
            'tables' => [
                'roomAvailabilityRows' => $data['roomAvailabilityRows'],
                'bookingTimeline' => $data['bookingTimeline'],
                'activityLogs' => collect($data['activityLogs'])->map(fn ($log) => [
                    'actor' => $log->adminUser?->name ?? 'System',
                    'action' => $log->action,
                    'target' => trim(($log->target_type ?? '') . ' #' . ($log->target_id ?? '')),
                    'created_at' => optional($log->created_at)->toIso8601String(),
                ])->values(),
                'topRoomTypes' => $data['topRoomTypes'],
            ],
            'generated_at' => $data['generated_at'],
        ]);
    }
}
