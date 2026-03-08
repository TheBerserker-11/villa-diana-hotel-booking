@extends('admin.layouts.app')
@section('title', 'Hotel Dashboard')

@section('content')
@php
    $offset = max(1, min(7, (int) data_get($calendar ?? [], 'offset', 1)));
    $days = data_get($calendar ?? [], 'days', []);
    $summary = data_get($calendar ?? [], 'summary', []);
@endphp

<div class="py-3 vd-page">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h2 class="mb-0">Hotel Dashboard</h2>
            <small class="vd-small-muted">Live every 5s <span class="ms-2 vd-pill vd-pill-success" id="liveBadge">LIVE</span> <span class="ms-2" id="updatedAt">-</span></small>
        </div>
        <div class="d-grid d-sm-flex gap-2">
            <a href="{{ route('admin.report', request()->query()) }}" class="btn btn-outline-light">View Full Report</a>
            <a href="{{ route('admin.report.pdf', request()->query()) }}" class="btn btn-warning">Download PDF</a>
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
        <div class="col-6 col-xl-3"><div class="kpi-card h-100"><div><div class="kpi-label">Total Rooms</div><div class="kpi-value" id="kRooms">{{ $totalRooms ?? 0 }}</div></div></div></div>
        <div class="col-6 col-xl-3"><div class="kpi-card h-100"><div><div class="kpi-label">Bookings</div><div class="kpi-value" id="kBookings">{{ $bookingsInRange ?? 0 }}</div></div></div></div>
        <div class="col-6 col-xl-3"><div class="kpi-card h-100"><div><div class="kpi-label">Revenue</div><div class="kpi-value" id="kRevenue">&#8369;{{ number_format($revenueInRange ?? 0, 0) }}</div></div></div></div>
        <div class="col-6 col-xl-3"><div class="kpi-card h-100"><div><div class="kpi-label">Prediction (7d)</div><div class="kpi-value" id="kPred">{{ data_get($prediction, 'expected_bookings_next_7', 0) }}</div><small id="kPredRev">&#8369;{{ number_format(data_get($prediction, 'expected_revenue_next_7', 0), 0) }}</small></div></div></div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-4"><div class="vd-card h-100"><div class="vd-card-header"><strong>Occupancy Trend</strong></div><div class="vd-card-body"><div class="vd-chart"><canvas id="cOcc"></canvas></div></div></div></div>
        <div class="col-12 col-xl-4"><div class="vd-card h-100"><div class="vd-card-header"><strong>Monthly Bookings</strong></div><div class="vd-card-body"><div class="vd-chart"><canvas id="cMonth"></canvas></div></div></div></div>
        <div class="col-12 col-xl-4"><div class="vd-card h-100"><div class="vd-card-header"><strong>Prediction Analysis</strong></div><div class="vd-card-body"><div class="vd-chart"><canvas id="cPred"></canvas></div></div></div></div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-12 col-xl-7">
            <div class="vd-card h-100">
                <div class="vd-card-header d-flex justify-content-between"><strong>Reservation Calendar</strong><span id="calLabel">{{ $calendar_label ?? now()->format('F Y') }}</span></div>
                <div class="vd-card-body">
                    <div class="vd-week"><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div><div>Sun</div></div>
                    <div class="vd-cal" id="calGrid">
                        @for($i = 1; $i < $offset; $i++) <div class="cell e"></div> @endfor
                        @foreach($days as $d)
                            <div class="cell {{ data_get($d, 'availability') }}"><strong>{{ data_get($d, 'day') }}</strong><small>{{ data_get($d, 'booked_count') }} booked</small></div>
                        @endforeach
                    </div>
                    <div class="small text-muted mt-2" id="calSummary">{{ data_get($summary, 'booked_days', 0) }} booked / {{ data_get($summary, 'fully_booked_days', 0) }} full / {{ data_get($summary, 'available_days', 0) }} available</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-5">
            <div class="vd-card h-100">
                <div class="vd-card-header"><strong>Room Availability Indicator</strong></div>
                <div class="vd-card-body p-0">
                    <div class="table-responsive">
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Room</th><th>Status</th><th>Units</th></tr></thead><tbody id="tAvail">
                            @forelse(($roomAvailabilityRows ?? collect()) as $r)
                                @php $s = data_get($r, 'availability', 'available'); $b = $s === 'available' ? 'bg-success' : ($s === 'booked_today' ? 'bg-warning text-dark' : 'bg-secondary'); @endphp
                                <tr><td>{{ data_get($r, 'room_type') }} (#{{ data_get($r, 'room_id') }})</td><td><span class="badge {{ $b }}">{{ strtoupper(str_replace('_', ' ', $s)) }}</span></td><td>{{ data_get($r, 'available_units') }}/{{ data_get($r, 'total_units') }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">No data.</td></tr>
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
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Guest</th><th>Room</th><th>Status</th><th>Updated</th></tr></thead><tbody id="tTimeline">
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
                        <table class="vd-table-bs vd-striped mb-0"><thead class="vd-thead"><tr><th>Admin</th><th>Action</th><th>Target</th><th>When</th></tr></thead><tbody id="tLogs">
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
    const setTime = (iso) => { const d = iso ? new Date(iso) : new Date(); const t = document.getElementById('updatedAt'); if (t) t.textContent = 'Last updated: ' + d.toLocaleTimeString(); };

    const occ = new Chart(document.getElementById('cOcc'), { type:'line', data:{ labels:@json($dates ?? []), datasets:[{ label:'Occupied', data:@json($occupancyCounts ?? []), fill:true, tension:.28 }] }, options:{ animation:{duration:800}, scales:{ y:{ beginAtZero:true } } } });
    const mon = new Chart(document.getElementById('cMonth'), { type:'bar', data:{ labels:@json($monthlyTrendLabels ?? []), datasets:[{ label:'Bookings', data:@json($monthlyTrendBookings ?? []) }] }, options:{ animation:{duration:800}, scales:{ y:{ beginAtZero:true } } } });
    const ph = @json(data_get($prediction, 'history_labels', [])); const pv = @json(data_get($prediction, 'history_bookings', [])); const fl = @json(data_get($prediction, 'labels', [])); const fv = @json(data_get($prediction, 'bookings', []));
    const pred = new Chart(document.getElementById('cPred'), { type:'line', data:{ labels: ph.concat(fl), datasets:[{ label:'Actual', data: pv.concat(new Array(fl.length).fill(null)), tension:.28 }, { label:'Predicted', data: new Array(Math.max(pv.length-1,0)).fill(null).concat(pv.length ? [pv[pv.length-1]] : []).concat(fv), borderDash:[6,6], tension:.28 }] }, options:{ animation:{duration:800}, scales:{ y:{ beginAtZero:true } } } });

    async function live() {
        try {
            const url = new URL("{{ route('admin.dashboard.live') }}", location.origin); q.forEach((v,k)=>url.searchParams.set(k,v));
            const r = await fetch(url.toString(), { headers:{ Accept:'application/json' }, credentials:'same-origin' });
            if (!r.ok) throw new Error('HTTP '+r.status);
            const p = await r.json();

            const k = p.kpis || {};
            document.getElementById('kRooms').textContent = Number(k.totalRooms || 0);
            document.getElementById('kBookings').textContent = Number(k.bookingsInRange || 0);
            document.getElementById('kRevenue').textContent = money(k.revenueInRange);
            document.getElementById('kPred').textContent = Number(p.prediction?.expected_bookings_next_7 || 0);
            document.getElementById('kPredRev').textContent = money(p.prediction?.expected_revenue_next_7 || 0);

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

            const cal = p.calendar || {};
            document.getElementById('calLabel').textContent = cal.label || '';
            const grid = document.getElementById('calGrid');
            if (grid) {
                const offset = Math.max(1, Math.min(7, Number(cal.offset || 1))); let html = '';
                for (let i = 1; i < offset; i++) html += '<div class="cell e"></div>';
                (cal.days || []).forEach((d) => html += `<div class="cell ${esc(d.availability)}"><strong>${Number(d.day || 0)}</strong><small>${Number(d.booked_count || 0)} booked</small></div>`);
                grid.innerHTML = html;
            }
            const s = cal.summary || {};
            const summary = document.getElementById('calSummary');
            if (summary) summary.textContent = `${Number(s.booked_days || 0)} booked / ${Number(s.fully_booked_days || 0)} full / ${Number(s.available_days || 0)} available`;

            const avail = document.getElementById('tAvail');
            if (avail) {
                const rows = p.tables?.roomAvailabilityRows || [];
                avail.innerHTML = rows.length ? rows.map((r) => {
                    const st = String(r.availability || 'available').toLowerCase();
                    const badge = st === 'available' ? 'bg-success' : (st === 'booked_today' ? 'bg-warning text-dark' : 'bg-secondary');
                    return `<tr><td>${esc(r.room_type)} (#${esc(r.room_id)})</td><td><span class="badge ${badge}">${esc(st.replaceAll('_',' ').toUpperCase())}</span></td><td>${Number(r.available_units || 0)}/${Number(r.total_units || 0)}</td></tr>`;
                }).join('') : '<tr><td colspan="3" class="text-center text-muted py-3">No data.</td></tr>';
            }

            const tl = document.getElementById('tTimeline');
            if (tl) {
                const rows = p.tables?.bookingTimeline || [];
                tl.innerHTML = rows.length ? rows.map((x) => {
                    const st = String(x.status || 'pending').toLowerCase();
                    const badge = st === 'confirmed' ? 'bg-success' : (st === 'cancelled' ? 'bg-secondary' : 'bg-warning text-dark');
                    return `<tr><td>${esc(x.guest || '')}</td><td>${esc(x.room_type || '')}</td><td><span class="badge ${badge}">${esc(st.toUpperCase())}</span></td><td>${esc(x.updated_human || '-')}</td></tr>`;
                }).join('') : '<tr><td colspan="4" class="text-center text-muted py-3">No timeline.</td></tr>';
            }

            const logs = document.getElementById('tLogs');
            if (logs) {
                const rows = p.tables?.activityLogs || [];
                logs.innerHTML = rows.length ? rows.map((x) => {
                    const action = String(x.action || 'activity').replaceAll('_',' ').replace(/\b\w/g, (m) => m.toUpperCase());
                    const when = x.created_at ? new Date(x.created_at).toLocaleTimeString() : '-';
                    return `<tr><td>${esc(x.actor || 'System')}</td><td>${esc(action)}</td><td>${esc(x.target || '-')}</td><td>${esc(when)}</td></tr>`;
                }).join('') : '<tr><td colspan="4" class="text-center text-muted py-3">No logs.</td></tr>';
            }

            setTime(p.generated_at);
            document.getElementById('liveBadge').className = 'ms-2 vd-pill vd-pill-success';
            document.getElementById('liveBadge').textContent = 'LIVE';
        } catch (e) {
            console.error(e);
            const b = document.getElementById('liveBadge');
            if (b) { b.className = 'ms-2 vd-pill vd-pill-danger'; b.textContent = 'OFFLINE'; }
        }
    }

    setTime();
    live();
    setInterval(live, 5000);
})();
</script>
@endsection
