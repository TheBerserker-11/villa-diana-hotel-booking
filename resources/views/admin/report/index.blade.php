@extends('admin.layouts.app')
@section('title', 'View Full Report')

@section('content')
@php
    $offset = max(1, min(7, (int) data_get($calendar ?? [], 'offset', 1)));
    $days = data_get($calendar ?? [], 'days', []);
    $summary = data_get($calendar ?? [], 'summary', []);
@endphp

<div class="py-3 vd-page">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h2 class="mb-0">View Full Report</h2>
            <small class="vd-small-muted">Weekly, monthly, annual, or custom range <span class="ms-2 vd-pill vd-pill-success" id="reportLiveBadge">LIVE</span> <span class="ms-2" id="reportUpdatedAt">-</span></small>
        </div>
        <div class="d-grid d-sm-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('admin.index', request()->query()) }}">Back to Dashboard</a>
            <a class="btn vd-btn vd-btn-primary" href="{{ route('admin.report.pdf', request()->query()) }}">Download PDF</a>
        </div>
    </div>

    <div class="vd-card mb-3">
        <div class="vd-card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-6 col-lg-2">
                    <label class="form-label mb-1">Type</label>
                    <select class="form-select vd-select" name="period">
                        <option value="weekly" {{ request('period', $period ?? 'monthly') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ request('period', $period ?? 'monthly') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="annual" {{ request('period', $period ?? 'monthly') === 'annual' ? 'selected' : '' }}>Annual</option>
                        <option value="custom" {{ request('period', $period ?? 'monthly') === 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>
                <div class="col-6 col-lg-2"><label class="form-label mb-1">Month</label><input type="month" class="form-control vd-input" name="month" value="{{ request('month', now()->format('Y-m')) }}"></div>
                <div class="col-6 col-lg-2"><label class="form-label mb-1">Calendar</label><input type="month" class="form-control vd-input" name="calendar_month" value="{{ request('calendar_month', $calendar_month ?? now()->format('Y-m')) }}"></div>
                <div class="col-6 col-lg-2"><label class="form-label mb-1">Year</label><input type="number" class="form-control vd-input" name="year" value="{{ request('year', now()->year) }}"></div>
                <div class="col-6 col-lg-2"><label class="form-label mb-1">Start</label><input type="date" class="form-control vd-input" name="start_date" value="{{ request('start_date', $start_date ?? '') }}"></div>
                <div class="col-6 col-lg-2"><label class="form-label mb-1">End</label><input type="date" class="form-control vd-input" name="end_date" value="{{ request('end_date', $end_date ?? '') }}"></div>
                <div class="col-12 col-lg-2 d-grid"><button class="btn vd-btn vd-btn-primary">Apply</button></div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-6 col-xl-2"><div class="kpi-card h-100"><div><div class="kpi-label">Revenue</div><div class="kpi-value" id="rkRevenue">&#8369;{{ number_format($revenueInRange ?? 0, 0) }}</div></div></div></div>
        <div class="col-6 col-xl-2"><div class="kpi-card h-100"><div><div class="kpi-label">Bookings</div><div class="kpi-value" id="rkBookings">{{ $bookingsInRange ?? 0 }}</div></div></div></div>
        <div class="col-6 col-xl-2"><div class="kpi-card h-100"><div><div class="kpi-label">Pending</div><div class="kpi-value" id="rkPending">{{ $pendingInRange ?? 0 }}</div></div></div></div>
        <div class="col-6 col-xl-2"><div class="kpi-card h-100"><div><div class="kpi-label">Cancelled</div><div class="kpi-value" id="rkCancelled">{{ $cancelledInRange ?? 0 }}</div></div></div></div>
        <div class="col-6 col-xl-2"><div class="kpi-card h-100"><div><div class="kpi-label">Cancel Rate</div><div class="kpi-value" id="rkCancelRate">{{ number_format($cancellationRate ?? 0, 1) }}%</div></div></div></div>
        <div class="col-6 col-xl-2"><div class="kpi-card h-100"><div><div class="kpi-label">Prediction (7d)</div><div class="kpi-value" id="rkPred">{{ data_get($prediction, 'expected_bookings_next_7', 0) }}</div></div></div></div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-4"><div class="vd-card h-100"><div class="vd-card-header"><strong>Occupancy Trend</strong></div><div class="vd-card-body"><div class="vd-chart"><canvas id="rOcc"></canvas></div></div></div></div>
        <div class="col-12 col-xl-4"><div class="vd-card h-100"><div class="vd-card-header"><strong>Monthly Bookings</strong></div><div class="vd-card-body"><div class="vd-chart"><canvas id="rMonth"></canvas></div></div></div></div>
        <div class="col-12 col-xl-4"><div class="vd-card h-100"><div class="vd-card-header"><strong>Prediction Analysis</strong></div><div class="vd-card-body"><div class="vd-chart"><canvas id="rPred"></canvas></div></div></div></div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-6">
            <div class="vd-card h-100">
                <div class="vd-card-header"><strong>Most Booked Rooms</strong></div>
                <div class="vd-card-body p-0">
                    <div class="table-responsive">
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Room Type</th><th>Bookings</th></tr></thead><tbody id="rMostBooked">
                            @forelse(($mostBookedRooms ?? collect()) as $room)
                                <tr><td>{{ $room->room?->roomType?->name ?? 'N/A' }}</td><td>{{ $room->orders_count ?? 0 }}</td></tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted py-3">No data.</td></tr>
                            @endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="vd-card h-100">
                <div class="vd-card-header"><strong>Current Check-Ins</strong></div>
                <div class="vd-card-body p-0">
                    <div class="table-responsive">
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Room</th><th>Guest</th><th>Check-In</th><th>Check-Out</th></tr></thead><tbody id="rCheckins">
                            @forelse(($currentCheckIns ?? collect()) as $order)
                                <tr>
                                    <td>{{ $order->room?->roomType?->name ?? 'N/A' }}</td>
                                    <td>{{ trim(($order->customer?->name ?? 'N/A') . ' ' . ($order->customer?->last_name ?? '')) }}</td>
                                    <td>{{ $order->check_in ? \Carbon\Carbon::parse($order->check_in)->format('Y-m-d') : '-' }}</td>
                                    <td>{{ $order->check_out ? \Carbon\Carbon::parse($order->check_out)->format('Y-m-d') : '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No check-ins.</td></tr>
                            @endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-7">
            <div class="vd-card h-100">
                <div class="vd-card-header d-flex justify-content-between"><strong>Reservation Calendar</strong><span id="rCalLabel">{{ $calendar_label ?? now()->format('F Y') }}</span></div>
                <div class="vd-card-body">
                    <div class="vd-week"><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div><div>Sun</div></div>
                    <div class="vd-cal" id="rCalGrid">
                        @for($i = 1; $i < $offset; $i++) <div class="cell e"></div> @endfor
                        @foreach($days as $d)
                            <div class="cell {{ data_get($d, 'availability') }}"><strong>{{ data_get($d, 'day') }}</strong><small>{{ data_get($d, 'booked_count') }} booked</small></div>
                        @endforeach
                    </div>
                    <div class="small text-muted mt-2" id="rCalSummary">{{ data_get($summary, 'booked_days', 0) }} booked / {{ data_get($summary, 'fully_booked_days', 0) }} full / {{ data_get($summary, 'available_days', 0) }} available</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-5">
            <div class="vd-card h-100">
                <div class="vd-card-header"><strong>Reference Leaderboard</strong></div>
                <div class="vd-card-body p-0">
                    <div class="table-responsive">
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Reference</th><th>Bookings</th></tr></thead><tbody id="rLeaderboard">
                            @forelse(($leaderboard ?? collect()) as $item)
                                @php $dup = in_array($item->reference_code, ($duplicateCodes ?? []), true); @endphp
                                <tr class="{{ $dup ? 'vd-dup' : '' }}"><td>{{ $item->reference_code }}</td><td>{{ $item->total_bookings }}</td></tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-muted py-3">No data.</td></tr>
                            @endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-xl-6">
            <div class="vd-card h-100">
                <div class="vd-card-header"><strong>Booking Timeline</strong></div>
                <div class="vd-card-body p-0">
                    <div class="table-responsive">
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Guest</th><th>Room</th><th>Status</th><th>Updated</th></tr></thead><tbody id="rTimeline">
                            @forelse(($bookingTimeline ?? collect()) as $x)
                                @php $s = data_get($x, 'status', 'pending'); $b = $s === 'confirmed' ? 'bg-success' : ($s === 'cancelled' ? 'bg-secondary' : 'bg-warning text-dark'); @endphp
                                <tr><td>{{ data_get($x, 'guest') }}</td><td>{{ data_get($x, 'room_type') }}</td><td><span class="badge {{ $b }}">{{ strtoupper($s) }}</span></td><td>{{ data_get($x, 'updated_human', '-') }}</td></tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No timeline.</td></tr>
                            @endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="vd-card h-100">
                <div class="vd-card-header"><strong>Admin Activity Logs</strong></div>
                <div class="vd-card-body p-0">
                    <div class="table-responsive">
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Admin</th><th>Action</th><th>Target</th><th>When</th></tr></thead><tbody id="rLogs">
                            @forelse(($activityLogs ?? collect()) as $log)
                                <tr><td>{{ $log->adminUser?->name ?? 'System' }}</td><td>{{ \Illuminate\Support\Str::headline((string) $log->action) }}</td><td>{{ trim(($log->target_type ?? '-') . ' #' . ($log->target_id ?? '')) }}</td><td>{{ optional($log->created_at)->diffForHumans() ?? '-' }}</td></tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">No logs.</td></tr>
                            @endforelse
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.vd-chart { position: relative; height: 240px; }
.vd-week, .vd-cal { display: grid; grid-template-columns: repeat(7, minmax(0,1fr)); gap: .35rem; }
.vd-week div { text-align: center; font-size: .7rem; color: var(--vd-muted); font-weight: 700; }
.vd-cal .cell { min-height: 62px; border: 1px solid var(--vd-border); border-radius: 9px; padding: .35rem; display: flex; flex-direction: column; justify-content: space-between; }
.vd-cal .cell small { font-size: .62rem; color: var(--vd-muted); }
.vd-cal .available { border-color: rgba(34,197,94,.55); }
.vd-cal .booked_today { border-color: rgba(245,158,11,.55); }
.vd-cal .unavailable { border-color: rgba(239,68,68,.55); }
.vd-cal .e { border-style: dashed; opacity: .35; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(() => {
    Chart.defaults.maintainAspectRatio = false;
    const q = new URLSearchParams(location.search);
    const money = (v) => '\u20B1' + Number(v || 0).toLocaleString();
    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (m) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
    const setTime = (iso) => { const d = iso ? new Date(iso) : new Date(); const t = document.getElementById('reportUpdatedAt'); if (t) t.textContent = 'Last updated: ' + d.toLocaleTimeString(); };

    const occ = new Chart(document.getElementById('rOcc'), { type:'line', data:{ labels:@json($dates ?? []), datasets:[{ label:'Occupied', data:@json($occupancyCounts ?? []), fill:true, tension:.28 }] }, options:{ animation:{duration:800}, scales:{ y:{ beginAtZero:true } } } });
    const mon = new Chart(document.getElementById('rMonth'), { type:'bar', data:{ labels:@json($monthlyTrendLabels ?? []), datasets:[{ label:'Bookings', data:@json($monthlyTrendBookings ?? []) }] }, options:{ animation:{duration:800}, scales:{ y:{ beginAtZero:true } } } });
    const ph = @json(data_get($prediction, 'history_labels', [])); const pv = @json(data_get($prediction, 'history_bookings', [])); const fl = @json(data_get($prediction, 'labels', [])); const fv = @json(data_get($prediction, 'bookings', []));
    const pred = new Chart(document.getElementById('rPred'), { type:'line', data:{ labels: ph.concat(fl), datasets:[{ label:'Actual', data: pv.concat(new Array(fl.length).fill(null)), tension:.28 }, { label:'Predicted', data: new Array(Math.max(pv.length-1,0)).fill(null).concat(pv.length ? [pv[pv.length-1]] : []).concat(fv), borderDash:[6,6], tension:.28 }] }, options:{ animation:{duration:800}, scales:{ y:{ beginAtZero:true } } } });

    async function live() {
        try {
            const url = new URL("{{ route('admin.report.live') }}", location.origin); q.forEach((v,k)=>url.searchParams.set(k,v));
            const r = await fetch(url.toString(), { headers:{ Accept:'application/json' }, credentials:'same-origin' });
            if (!r.ok) throw new Error('HTTP '+r.status);
            const p = await r.json();

            const k = p.kpis || {};
            document.getElementById('rkRevenue').textContent = money(k.revenueInRange);
            document.getElementById('rkBookings').textContent = Number(k.bookingsInRange || 0);
            document.getElementById('rkPending').textContent = Number(k.pendingInRange || 0);
            document.getElementById('rkCancelled').textContent = Number(k.cancelledInRange || 0);
            document.getElementById('rkCancelRate').textContent = Number(k.cancellationRate || 0).toFixed(1) + '%';
            document.getElementById('rkPred').textContent = Number(p.prediction?.expected_bookings_next_7 || 0);

            occ.data.labels = p.charts?.occupancyTrend?.labels || [];
            occ.data.datasets[0].data = p.charts?.occupancyTrend?.data || [];
            occ.update();
            mon.data.labels = p.charts?.monthlyBookings?.labels || [];
            mon.data.datasets[0].data = p.charts?.monthlyBookings?.data || [];
            mon.update();

            const hLabels = p.prediction?.history_labels || [];
            const hVals = p.prediction?.history_bookings || [];
            const fLabels = p.prediction?.labels || [];
            const fVals = p.prediction?.bookings || [];
            pred.data.labels = hLabels.concat(fLabels);
            pred.data.datasets[0].data = hVals.concat(new Array(fLabels.length).fill(null));
            pred.data.datasets[1].data = new Array(Math.max(hVals.length - 1, 0)).fill(null).concat(hVals.length ? [hVals[hVals.length - 1]] : []).concat(fVals);
            pred.update();

            const fill = (id, html, emptyCols) => { const body = document.getElementById(id); if (body) body.innerHTML = html || `<tr><td colspan="${emptyCols}" class="text-center text-muted py-3">No data.</td></tr>`; };
            fill('rMostBooked', (p.tables?.mostBookedRooms || []).map((x) => `<tr><td>${esc(x.room_type)}</td><td>${Number(x.orders_count || 0)}</td></tr>`).join(''), 2);
            fill('rCheckins', (p.tables?.currentCheckIns || []).map((x) => `<tr><td>${esc(x.room_type)}</td><td>${esc(x.guest)}</td><td>${esc(x.check_in)}</td><td>${esc(x.check_out)}</td></tr>`).join(''), 4);
            fill('rLeaderboard', (p.tables?.leaderboard || []).map((x) => `<tr class="${x.duplicate ? 'vd-dup' : ''}"><td>${esc(x.reference_code)}</td><td>${Number(x.total_bookings || 0)}</td></tr>`).join(''), 2);
            fill('rTimeline', (p.tables?.bookingTimeline || []).map((x) => { const st = String(x.status || 'pending').toLowerCase(); const badge = st === 'confirmed' ? 'bg-success' : (st === 'cancelled' ? 'bg-secondary' : 'bg-warning text-dark'); return `<tr><td>${esc(x.guest || '')}</td><td>${esc(x.room_type || '')}</td><td><span class="badge ${badge}">${esc(st.toUpperCase())}</span></td><td>${esc(x.updated_human || '-')}</td></tr>`; }).join(''), 4);
            fill('rLogs', (p.tables?.activityLogs || []).map((x) => { const action = String(x.action || 'activity').replaceAll('_',' ').replace(/\b\w/g, (m) => m.toUpperCase()); const when = x.created_at ? new Date(x.created_at).toLocaleTimeString() : '-'; return `<tr><td>${esc(x.actor || 'System')}</td><td>${esc(action)}</td><td>${esc(x.target || '-')}</td><td>${esc(when)}</td></tr>`; }).join(''), 4);

            const cal = p.calendar || {};
            document.getElementById('rCalLabel').textContent = cal.label || '';
            const grid = document.getElementById('rCalGrid');
            if (grid) {
                const off = Math.max(1, Math.min(7, Number(cal.offset || 1))); let html = '';
                for (let i = 1; i < off; i++) html += '<div class="cell e"></div>';
                (cal.days || []).forEach((d) => html += `<div class="cell ${esc(d.availability)}"><strong>${Number(d.day || 0)}</strong><small>${Number(d.booked_count || 0)} booked</small></div>`);
                grid.innerHTML = html;
            }
            const s = cal.summary || {};
            document.getElementById('rCalSummary').textContent = `${Number(s.booked_days || 0)} booked / ${Number(s.fully_booked_days || 0)} full / ${Number(s.available_days || 0)} available`;

            setTime(p.generated_at);
            const badge = document.getElementById('reportLiveBadge'); if (badge) { badge.className = 'ms-2 vd-pill vd-pill-success'; badge.textContent = 'LIVE'; }
        } catch (e) {
            console.error(e);
            const badge = document.getElementById('reportLiveBadge'); if (badge) { badge.className = 'ms-2 vd-pill vd-pill-danger'; badge.textContent = 'OFFLINE'; }
        }
    }

    setTime();
    live();
    setInterval(live, 5000);
})();
</script>
@endsection
