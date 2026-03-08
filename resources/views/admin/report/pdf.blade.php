<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Villa Diana Full Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h2, h3 { margin: 0 0 6px; }
        .muted { color: #666; }
        .section { margin-top: 14px; }
        .header { border-bottom: 2px solid #111; padding-bottom: 10px; margin-bottom: 10px; }
        .header table { width: 100%; border-collapse: collapse; }
        .logo { width: 56px; height: 56px; object-fit: contain; }
        .kpis { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .kpis td { border: 1px solid #ddd; padding: 8px; vertical-align: top; }
        .label { color: #666; font-size: 10px; }
        .value { font-size: 15px; font-weight: 700; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #111; color: #fff; text-align: left; }
        .center { text-align: center; }
        .right { text-align: right; }
        .bar-wrap { width: 100%; background: #f1f1f1; border-radius: 999px; height: 10px; }
        .bar { height: 10px; border-radius: 999px; background: #1d4ed8; }
        .bar.pred { background: #ca8a04; }
    </style>
</head>
<body>
@php
    $logoPath = public_path('img/logo/logo.png');
    $monthlyMax = max((array)($monthlyTrendBookings ?? [1])) ?: 1;
    $predMax = max((array) data_get($prediction, 'bookings', [1])) ?: 1;
@endphp

<div class="header">
    <table>
        <tr>
            <td style="width:70px;">
                @if(file_exists($logoPath))
                    <img class="logo" src="{{ $logoPath }}" alt="Villa Diana Logo">
                @endif
            </td>
            <td>
                <h2>Villa Diana Hotel - Full Analytics Report</h2>
                <div class="muted">Period Type: <strong>{{ ucfirst($period ?? 'monthly') }}</strong></div>
                <div class="muted">Range: {{ $start_date ?? '' }} to {{ $end_date ?? '' }}</div>
                <div class="muted">Generated: {{ $generated_at ?? '' }}</div>
            </td>
        </tr>
    </table>
</div>

<table class="kpis">
    <tr>
        <td><div class="label">Revenue (Range)</div><div class="value">&#8369;{{ number_format($revenueInRange ?? 0, 2) }}</div></td>
        <td><div class="label">Bookings (Range)</div><div class="value">{{ $bookingsInRange ?? 0 }}</div></td>
        <td><div class="label">Pending</div><div class="value">{{ $pendingInRange ?? 0 }}</div></td>
        <td><div class="label">Cancelled</div><div class="value">{{ $cancelledInRange ?? 0 }}</div></td>
    </tr>
    <tr>
        <td><div class="label">Cancellation Rate</div><div class="value">{{ number_format($cancellationRate ?? 0, 1) }}%</div></td>
        <td><div class="label">Avg Booking Value</div><div class="value">&#8369;{{ number_format($avgBookingValue ?? 0, 2) }}</div></td>
        <td><div class="label">Avg Stay Length</div><div class="value">{{ number_format($avgStayLength ?? 0, 1) }} night(s)</div></td>
        <td><div class="label">RevPAR</div><div class="value">&#8369;{{ number_format($revPar ?? 0, 2) }}</div></td>
    </tr>
    <tr>
        <td colspan="2"><div class="label">Occupancy Today</div><div class="value">{{ number_format($occupancyRateToday ?? 0, 1) }}%</div><div class="muted">{{ $occupiedToday ?? 0 }} occupied / {{ $totalRooms ?? 0 }} rooms</div></td>
        <td colspan="2"><div class="label">Prediction (Next 7 Days)</div><div class="value">{{ data_get($prediction, 'expected_bookings_next_7', 0) }} bookings</div><div class="muted">Projected revenue: &#8369;{{ number_format(data_get($prediction, 'expected_revenue_next_7', 0), 2) }}</div></td>
    </tr>
</table>

<div class="section">
    <h3>Monthly Booking Chart (Table + Graph Bars)</h3>
    <table>
        <thead>
            <tr><th>Month</th><th style="width:90px;">Bookings</th><th>Graph</th></tr>
        </thead>
        <tbody>
        @foreach(($monthlyTrendLabels ?? []) as $idx => $label)
            @php $value = (int) (($monthlyTrendBookings[$idx] ?? 0)); $w = max(2, (int) round(($value / $monthlyMax) * 100)); @endphp
            <tr>
                <td>{{ $label }}</td>
                <td class="center">{{ $value }}</td>
                <td><div class="bar-wrap"><div class="bar" style="width:{{ $w }}%;"></div></div></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Prediction Analysis (Next 7 Days)</h3>
    <table>
        <thead>
            <tr><th>Date</th><th style="width:90px;">Predicted Bookings</th><th>Graph</th></tr>
        </thead>
        <tbody>
        @foreach((data_get($prediction, 'labels', []) ?? []) as $idx => $label)
            @php $value = (int) (data_get($prediction, 'bookings.'.$idx, 0)); $w = max(2, (int) round(($value / $predMax) * 100)); @endphp
            <tr>
                <td>{{ $label }}</td>
                <td class="center">{{ $value }}</td>
                <td><div class="bar-wrap"><div class="bar pred" style="width:{{ $w }}%;"></div></div></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Reservation Calendar Summary ({{ $calendar_label ?? '' }})</h3>
    <table>
        <thead><tr><th>Booked Days</th><th>Fully Booked Days</th><th>Available Days</th></tr></thead>
        <tbody>
            <tr>
                <td class="center">{{ data_get($calendar, 'summary.booked_days', 0) }}</td>
                <td class="center">{{ data_get($calendar, 'summary.fully_booked_days', 0) }}</td>
                <td class="center">{{ data_get($calendar, 'summary.available_days', 0) }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Most Booked Rooms</h3>
    <table>
        <thead><tr><th>Room Type</th><th style="width:120px;">Bookings</th></tr></thead>
        <tbody>
        @forelse(($mostBookedRooms ?? collect()) as $room)
            <tr><td>{{ $room->room?->roomType?->name ?? 'N/A' }}</td><td class="center">{{ $room->orders_count ?? 0 }}</td></tr>
        @empty
            <tr><td colspan="2" class="center">No data.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Current Check-Ins</h3>
    <table>
        <thead><tr><th>Room</th><th>Guest</th><th style="width:95px;">Check-In</th><th style="width:95px;">Check-Out</th></tr></thead>
        <tbody>
        @forelse(($currentCheckIns ?? collect()) as $o)
            <tr>
                <td>{{ $o->room?->roomType?->name ?? 'N/A' }}</td>
                <td>{{ trim(($o->customer?->name ?? 'N/A') . ' ' . ($o->customer?->last_name ?? '')) }}</td>
                <td class="center">{{ $o->check_in ? \Carbon\Carbon::parse($o->check_in)->format('Y-m-d') : '-' }}</td>
                <td class="center">{{ $o->check_out ? \Carbon\Carbon::parse($o->check_out)->format('Y-m-d') : '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="center">No check-ins.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Reference Leaderboard</h3>
    <table>
        <thead><tr><th>Reference Code</th><th style="width:120px;">Bookings</th></tr></thead>
        <tbody>
        @forelse(($leaderboard ?? collect()) as $row)
            <tr><td>{{ $row->reference_code }}</td><td class="center">{{ (int)($row->total_bookings ?? 0) }}</td></tr>
        @empty
            <tr><td colspan="2" class="center">No data.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Booking Timeline</h3>
    <table>
        <thead><tr><th>Guest</th><th>Room</th><th>Status</th><th>Updated</th></tr></thead>
        <tbody>
        @forelse(($bookingTimeline ?? collect())->take(12) as $row)
            <tr>
                <td>{{ data_get($row, 'guest') }}</td>
                <td>{{ data_get($row, 'room_type') }}</td>
                <td>{{ strtoupper(data_get($row, 'status', 'pending')) }}</td>
                <td>{{ data_get($row, 'updated_human', '-') }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="center">No timeline.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="section">
    <h3>Admin Activity Logs</h3>
    <table>
        <thead><tr><th>Admin</th><th>Action</th><th>Target</th><th>When</th></tr></thead>
        <tbody>
        @forelse(($activityLogs ?? collect())->take(12) as $log)
            <tr>
                <td>{{ $log->adminUser?->name ?? 'System' }}</td>
                <td>{{ \Illuminate\Support\Str::headline((string) $log->action) }}</td>
                <td>{{ trim(($log->target_type ?? '-') . ' #' . ($log->target_id ?? '')) }}</td>
                <td>{{ optional($log->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="center">No activity logs.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

</body>
</html>
