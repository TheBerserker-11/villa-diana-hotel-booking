<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\Order;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminAnalyticsService
{
    private const FORECAST_DAYS = 7;
    private const HISTORY_DAYS = 14;
    private const TREND_DAYS = 30;

    public function build(array $filters = []): array
    {
        [$start, $end, $period, $periodLabel] = $this->resolveRange($filters);
        [$calendarStart, $calendarEnd, $calendarLabel, $calendarMonth] = $this->resolveCalendarMonth($filters);

        $today = Carbon::today();
        $daysInRange = max($start->copy()->startOfDay()->diffInDays($end->copy()->endOfDay()) + 1, 1);

        $totalRooms = (int) Room::sum('total_room');
        $totalBeds = (int) Room::sum('no_beds');

        $occupiedToday = (int) Order::where('status', 'confirmed')
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>', $today)
            ->count();

        $availableRooms = max($totalRooms - $occupiedToday, 0);
        $upcomingCheckins = (int) Order::where('status', 'confirmed')
            ->whereDate('check_in', $today)
            ->count();

        $reservedRooms = (int) Order::where('status', 'confirmed')->count();

        $occupancyRateToday = $totalRooms > 0
            ? round(($occupiedToday / $totalRooms) * 100, 1)
            : 0.0;

        $revenueToday = (float) Order::where('status', 'confirmed')
            ->whereDate('created_at', $today)
            ->sum('total_amount');

        $confirmedRangeQuery = Order::where('status', 'confirmed')
            ->whereBetween('created_at', [$start, $end]);

        $bookingsInRange = (int) (clone $confirmedRangeQuery)->count();
        $revenueInRange = (float) (clone $confirmedRangeQuery)->sum('total_amount');

        $pendingInRange = (int) Order::where('status', 'pending')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $cancelledInRange = (int) Order::where('status', 'cancelled')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $decisionTotal = max($bookingsInRange + $cancelledInRange, 1);
        $cancellationRate = round(($cancelledInRange / $decisionTotal) * 100, 1);

        $avgBookingValue = $bookingsInRange > 0
            ? round($revenueInRange / $bookingsInRange, 2)
            : 0.0;

        $avgStayLength = (float) Order::where('status', 'confirmed')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('AVG(GREATEST(DATEDIFF(check_out, check_in), 1)) as avg_stay')
            ->value('avg_stay');

        $avgStayLength = round(max($avgStayLength, 0), 1);

        $revPar = ($totalRooms > 0 && $daysInRange > 0)
            ? round($revenueInRange / ($totalRooms * $daysInRange), 2)
            : 0.0;

        $mostBookedRooms = Order::with(['room.roomType'])
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$start, $end])
            ->select('room_id', DB::raw('COUNT(*) as orders_count'))
            ->groupBy('room_id')
            ->orderByDesc('orders_count')
            ->take(10)
            ->get();

        $currentCheckIns = Order::with(['room.roomType', 'customer'])
            ->where('status', 'confirmed')
            ->whereDate('check_in', '<=', $today)
            ->whereDate('check_out', '>', $today)
            ->orderBy('check_in')
            ->get();

        [$dates, $occupancyCounts, $trendBookings, $trendRevenue] = $this->buildDailyTrend($today);
        [$monthlyTrendLabels, $monthlyTrendBookings] = $this->buildMonthlyBookingTrend();
        [$weekdayLabels, $weekdayBookings] = $this->buildWeekdayBookings();

        $topRoomTypes = DB::table('orders')
            ->join('rooms', 'orders.room_id', '=', 'rooms.id')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->where('orders.status', 'confirmed')
            ->whereBetween('orders.created_at', [$start, $end])
            ->select(
                'room_types.name as room_type',
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(COALESCE(orders.total_amount, 0)) as total_revenue')
            )
            ->groupBy('room_types.name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        $leaderboard = DB::table('orders')
            ->select('reference_code', DB::raw('COUNT(*) as total_bookings'))
            ->where('status', 'confirmed')
            ->whereNotNull('reference_code')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('reference_code')
            ->orderByDesc('total_bookings')
            ->get();

        $top5 = $leaderboard->take(5)->values();
        $duplicateCodes = $leaderboard
            ->filter(fn ($row) => (int) $row->total_bookings > 1)
            ->pluck('reference_code')
            ->values()
            ->all();

        $prediction = $this->buildPrediction();
        $calendar = $this->buildCalendarData($calendarStart, $calendarEnd, $totalRooms);
        $roomAvailability = $this->buildRoomAvailabilityRows($today);
        $bookingTimeline = $this->buildBookingTimeline();
        $activityLogs = Schema::hasTable('admin_activity_logs')
            ? AdminActivityLog::with('adminUser')->latest('id')->limit(15)->get()
            : collect();

        $availabilitySummary = [
            'available' => $roomAvailability->where('availability', 'available')->count(),
            'booked_today' => $roomAvailability->where('availability', 'booked_today')->count(),
            'unavailable' => $roomAvailability->where('availability', 'unavailable')->count(),
        ];

        return [
            'period' => $period,
            'periodLabel' => $periodLabel,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'calendar_month' => $calendarMonth,
            'calendar_label' => $calendarLabel,

            'totalRooms' => $totalRooms,
            'totalBeds' => $totalBeds,
            'reservedRooms' => $reservedRooms,
            'availableRooms' => $availableRooms,
            'upcomingCheckins' => $upcomingCheckins,
            'occupiedToday' => $occupiedToday,
            'occupancyRateToday' => $occupancyRateToday,

            'revenueToday' => $revenueToday,
            'revenueInRange' => $revenueInRange,
            'bookingsInRange' => $bookingsInRange,
            'pendingInRange' => $pendingInRange,
            'cancelledInRange' => $cancelledInRange,
            'cancellationRate' => $cancellationRate,
            'avgBookingValue' => $avgBookingValue,
            'avgStayLength' => $avgStayLength,
            'revPar' => $revPar,

            'dates' => $dates,
            'occupancyCounts' => $occupancyCounts,
            'trendBookings' => $trendBookings,
            'trendRevenue' => $trendRevenue,
            'monthlyTrendLabels' => $monthlyTrendLabels,
            'monthlyTrendBookings' => $monthlyTrendBookings,
            'weekdayLabels' => $weekdayLabels,
            'weekdayBookings' => $weekdayBookings,

            'mostBookedRooms' => $mostBookedRooms,
            'currentCheckIns' => $currentCheckIns,
            'topRoomTypes' => $topRoomTypes,
            'leaderboard' => $leaderboard,
            'top5' => $top5,
            'duplicateCodes' => $duplicateCodes,

            'prediction' => $prediction,
            'calendar' => $calendar,
            'roomAvailabilityRows' => $roomAvailability,
            'roomAvailabilitySummary' => $availabilitySummary,
            'bookingTimeline' => $bookingTimeline,
            'activityLogs' => $activityLogs,

            'generated_at' => now()->toIso8601String(),
        ];
    }

    private function resolveRange(array $filters): array
    {
        $today = Carbon::today();
        $period = strtolower((string) ($filters['period'] ?? 'monthly'));

        if (!in_array($period, ['weekly', 'monthly', 'annual', 'custom'], true)) {
            $period = 'monthly';
        }

        if ($period === 'weekly') {
            $anchor = $this->safeDate($filters['anchor_date'] ?? null) ?? $today;
            $start = $anchor->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
            $end = $anchor->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();
            $label = 'Weekly';
            return [$start, $end, $period, $label];
        }

        if ($period === 'annual') {
            $year = (int) ($filters['year'] ?? $today->year);
            if ($year < 2000 || $year > 2100) {
                $year = $today->year;
            }
            $start = Carbon::create($year, 1, 1)->startOfDay();
            $end = Carbon::create($year, 12, 31)->endOfDay();
            $label = 'Annual';
            return [$start, $end, $period, $label];
        }

        if ($period === 'custom') {
            $start = $this->safeDate($filters['start_date'] ?? null);
            $end = $this->safeDate($filters['end_date'] ?? null);

            if (!$start || !$end) {
                $period = 'monthly';
            } else {
                $start = $start->copy()->startOfDay();
                $end = $end->copy()->endOfDay();

                if ($start->gt($end)) {
                    [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
                }

                return [$start, $end, $period, 'Custom'];
            }
        }

        $monthValue = (string) ($filters['month'] ?? '');
        if (preg_match('/^\d{4}-\d{2}$/', $monthValue) === 1) {
            [$year, $month] = array_map('intval', explode('-', $monthValue));
            $monthDate = Carbon::create($year, $month, 1);
        } else {
            $monthDate = Carbon::today()->startOfMonth();
        }

        $start = $monthDate->copy()->startOfMonth()->startOfDay();
        $end = $monthDate->copy()->endOfMonth()->endOfDay();

        return [$start, $end, 'monthly', 'Monthly'];
    }

    private function resolveCalendarMonth(array $filters): array
    {
        $rawMonth = (string) ($filters['calendar_month'] ?? '');

        if (preg_match('/^\d{4}-\d{2}$/', $rawMonth) === 1) {
            [$year, $month] = array_map('intval', explode('-', $rawMonth));
            $monthDate = Carbon::create($year, $month, 1)->startOfMonth();
        } else {
            $monthDate = Carbon::today()->startOfMonth();
        }

        return [
            $monthDate->copy()->startOfMonth(),
            $monthDate->copy()->endOfMonth(),
            $monthDate->format('F Y'),
            $monthDate->format('Y-m'),
        ];
    }

    private function buildDailyTrend(Carbon $today): array
    {
        $dates = [];
        $occupancyCounts = [];
        $trendBookings = [];
        $trendRevenue = [];

        for ($i = self::TREND_DAYS - 1; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $dateStr = $date->toDateString();
            $dates[] = $dateStr;

            $occupancyCounts[] = (int) Order::where('status', 'confirmed')
                ->whereDate('check_in', '<=', $dateStr)
                ->whereDate('check_out', '>', $dateStr)
                ->count();

            $trendBookings[] = (int) Order::where('status', 'confirmed')
                ->whereDate('created_at', $dateStr)
                ->count();

            $trendRevenue[] = (float) Order::where('status', 'confirmed')
                ->whereDate('created_at', $dateStr)
                ->sum('total_amount');
        }

        return [$dates, $occupancyCounts, $trendBookings, $trendRevenue];
    }

    private function buildMonthlyBookingTrend(): array
    {
        $labels = [];
        $values = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::today()->subMonths($i);
            $labels[] = $month->format('M Y');
            $values[] = (int) Order::where('status', 'confirmed')
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
        }

        return [$labels, $values];
    }

    private function buildWeekdayBookings(): array
    {
        $weekdayLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $weekdayMap = [
            'Mon' => 'Monday',
            'Tue' => 'Tuesday',
            'Wed' => 'Wednesday',
            'Thu' => 'Thursday',
            'Fri' => 'Friday',
            'Sat' => 'Saturday',
            'Sun' => 'Sunday',
        ];

        $weekdayBookings = [];
        foreach ($weekdayLabels as $abbr) {
            $weekdayBookings[] = (int) Order::where('status', 'confirmed')
                ->whereRaw('DAYNAME(check_in) = ?', [$weekdayMap[$abbr]])
                ->count();
        }

        return [$weekdayLabels, $weekdayBookings];
    }

    private function buildPrediction(): array
    {
        $historyLabels = [];
        $historyBookings = [];
        $historyRevenue = [];

        for ($i = self::HISTORY_DAYS - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->toDateString();

            $historyLabels[] = $dateStr;
            $historyBookings[] = (int) Order::where('status', 'confirmed')
                ->whereDate('created_at', $dateStr)
                ->count();
            $historyRevenue[] = (float) Order::where('status', 'confirmed')
                ->whereDate('created_at', $dateStr)
                ->sum('total_amount');
        }

        [$predictedBookings, $bookingSlope] = $this->linearForecast($historyBookings, self::FORECAST_DAYS, 0, true);
        [$predictedRevenue, $revenueSlope] = $this->linearForecast($historyRevenue, self::FORECAST_DAYS, 0.0, false);

        $predictionLabels = [];
        for ($i = 1; $i <= self::FORECAST_DAYS; $i++) {
            $predictionLabels[] = Carbon::today()->addDays($i)->toDateString();
        }

        $direction = 'stable';
        if ($bookingSlope > 0.05 || $revenueSlope > 100) {
            $direction = 'up';
        } elseif ($bookingSlope < -0.05 || $revenueSlope < -100) {
            $direction = 'down';
        }

        return [
            'history_labels' => $historyLabels,
            'history_bookings' => $historyBookings,
            'history_revenue' => $historyRevenue,
            'labels' => $predictionLabels,
            'bookings' => $predictedBookings,
            'revenue' => $predictedRevenue,
            'expected_bookings_next_7' => (int) round(array_sum($predictedBookings)),
            'expected_revenue_next_7' => (float) round(array_sum($predictedRevenue), 2),
            'direction' => $direction,
        ];
    }

    private function linearForecast(array $history, int $steps, float|int $floor = 0, bool $roundToInt = true): array
    {
        $n = count($history);
        if ($n === 0) {
            return [array_fill(0, $steps, $floor), 0.0];
        }

        $xAvg = ($n - 1) / 2;
        $yAvg = array_sum($history) / $n;

        $num = 0.0;
        $den = 0.0;
        foreach ($history as $i => $y) {
            $num += ($i - $xAvg) * ((float) $y - $yAvg);
            $den += ($i - $xAvg) ** 2;
        }

        $slope = $den > 0 ? ($num / $den) : 0.0;
        $intercept = $yAvg - ($slope * $xAvg);

        $forecast = [];
        for ($s = 0; $s < $steps; $s++) {
            $x = $n + $s;
            $value = $intercept + ($slope * $x);
            $value = max((float) $floor, $value);
            $forecast[] = $roundToInt ? (int) round($value) : round($value, 2);
        }

        return [$forecast, $slope];
    }

    private function buildCalendarData(Carbon $start, Carbon $end, int $totalRooms): array
    {
        $dayCounts = [];
        for ($cursor = $start->copy(); $cursor->lte($end); $cursor->addDay()) {
            $dayCounts[$cursor->toDateString()] = 0;
        }

        $bookings = Order::whereIn('status', ['pending', 'confirmed'])
            ->whereDate('check_in', '<=', $end->toDateString())
            ->whereDate('check_out', '>', $start->toDateString())
            ->get(['check_in', 'check_out']);

        foreach ($bookings as $booking) {
            $from = Carbon::parse($booking->check_in)->startOfDay();
            $to = Carbon::parse($booking->check_out)->subDay()->startOfDay();

            if ($from->lt($start)) {
                $from = $start->copy();
            }
            if ($to->gt($end)) {
                $to = $end->copy();
            }
            if ($from->gt($to)) {
                continue;
            }

            for ($cursor = $from->copy(); $cursor->lte($to); $cursor->addDay()) {
                $key = $cursor->toDateString();
                if (array_key_exists($key, $dayCounts)) {
                    $dayCounts[$key]++;
                }
            }
        }

        $cells = [];
        $bookedDays = 0;
        $fullDays = 0;

        foreach ($dayCounts as $date => $count) {
            $availability = 'available';
            if ($count > 0) {
                $availability = 'booked_today';
                $bookedDays++;
            }
            if ($totalRooms > 0 && $count >= $totalRooms) {
                $availability = 'unavailable';
                $fullDays++;
            }

            $cells[] = [
                'date' => $date,
                'day' => (int) Carbon::parse($date)->day,
                'booked_count' => (int) $count,
                'availability' => $availability,
                'occupancy_percent' => $totalRooms > 0 ? round(($count / $totalRooms) * 100, 1) : 0.0,
                'is_today' => Carbon::parse($date)->isToday(),
            ];
        }

        return [
            'offset' => (int) $start->copy()->dayOfWeekIso, // 1 (Mon) .. 7 (Sun)
            'days' => $cells,
            'summary' => [
                'booked_days' => $bookedDays,
                'fully_booked_days' => $fullDays,
                'available_days' => max(count($cells) - $bookedDays, 0),
            ],
        ];
    }

    private function buildRoomAvailabilityRows(Carbon $date): Collection
    {
        $dateString = $date->toDateString();
        $bookedByRoom = Order::select('room_id', DB::raw('COUNT(*) as booked_count'))
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('check_in', '<=', $dateString)
            ->whereDate('check_out', '>', $dateString)
            ->groupBy('room_id')
            ->pluck('booked_count', 'room_id');

        return Room::with('roomType')
            ->orderBy('id')
            ->limit(14)
            ->get()
            ->map(function (Room $room) use ($bookedByRoom) {
                $totalUnits = max((int) ($room->total_room ?? 0), 0);
                $bookedUnits = (int) ($bookedByRoom[$room->id] ?? 0);
                $active = !Schema::hasColumn('rooms', 'status') || (bool) $room->status;

                if (!$active || $totalUnits <= 0) {
                    $availability = 'unavailable';
                } elseif ($bookedUnits <= 0) {
                    $availability = 'available';
                } elseif ($bookedUnits >= $totalUnits) {
                    $availability = 'unavailable';
                } else {
                    $availability = 'booked_today';
                }

                return [
                    'room_id' => (int) $room->id,
                    'room_type' => $room->roomType?->name ?? 'N/A',
                    'total_units' => $totalUnits,
                    'booked_units' => $bookedUnits,
                    'available_units' => max($totalUnits - $bookedUnits, 0),
                    'availability' => $availability,
                ];
            })
            ->values();
    }

    private function buildBookingTimeline(): Collection
    {
        return Order::with(['room.roomType', 'user'])
            ->latest('updated_at')
            ->limit(20)
            ->get()
            ->map(function (Order $order) {
                return [
                    'id' => (int) $order->id,
                    'status' => strtolower((string) ($order->status ?? 'pending')),
                    'room_type' => $order->room?->roomType?->name ?? 'N/A',
                    'guest' => trim(($order->user?->name ?? 'Guest') . ' ' . ($order->user?->last_name ?? '')),
                    'check_in' => optional($order->check_in)->format('Y-m-d'),
                    'check_out' => optional($order->check_out)->format('Y-m-d'),
                    'updated_at' => optional($order->updated_at)->toIso8601String(),
                    'updated_human' => optional($order->updated_at)->diffForHumans(),
                ];
            })
            ->values();
    }

    private function safeDate(?string $value): ?Carbon
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
