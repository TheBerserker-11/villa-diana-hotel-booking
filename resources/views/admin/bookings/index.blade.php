@extends('admin.layouts.app')

@section('content')
@php
    use Carbon\Carbon;

    $maskEmail = function (?string $email): string {
        if (!$email || !str_contains($email, '@')) return $email ?? '';
        [$name, $domain] = explode('@', $email, 2);

        $keep  = substr($name, 0, 2);
        $stars = str_repeat('*', max(strlen($name) - 2, 6));

        return $keep . $stars . '@' . $domain;
    };

    $fmtDate = function ($value): string {
        if (empty($value)) return '-';
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return '-';
        }
    };

    $peso = function ($v): string {
        return '₱' . number_format((float)($v ?? 0), 0);
    };
@endphp

<div class="py-3 vd-page">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
        <div class="flex-grow-1">
            <h2 class="mb-0 vd-title">
                All Bookings <small class="vd-small-muted">(Live)</small>
            </h2>
        </div>

        <div class="d-grid d-sm-flex gap-2">
            <a
                href="{{ route('admin.orders.export', request()->only(['search', 'reference_code', 'status_filter', 'room_type_id', 'check_in_from', 'check_in_to'])) }}"
                class="btn btn-success"
                id="bookingsExportBtn"
                data-base-url="{{ route('admin.orders.export') }}"
            >
                <i class="bi bi-file-earmark-excel me-1"></i> Download Excel
            </a>
            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <form id="bookingFilterForm" method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 mb-2">
        <div class="col-12 col-md-4">
            <input
                id="bookingSearchInput"
                type="text"
                name="search"
                value="{{ $search ?? request('search','') }}"
                class="form-control vd-input"
                placeholder="Search by guest name / phone / reference code..."
                autocomplete="off"
            >
            <div id="bookingLiveCount" class="form-text text-muted mt-1 d-none"></div>
        </div>

        <div class="col-12 col-md-3">
            <select id="referenceFilterSelect" name="reference_code" class="form-select vd-select">
                <option value="">All Reference Codes</option>
                @foreach(($referencestats ?? collect()) as $stat)
                    <option value="{{ $stat->reference_code }}"
                        {{ (request('reference_code','') == $stat->reference_code) ? 'selected' : '' }}>
                        {{ $stat->reference_code }} ({{ $stat->total }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-6 col-md-2">
            <select id="statusFilterSelect" name="status_filter" class="form-select vd-select">
                <option value="">All Statuses</option>
                <option value="pending" {{ ($statusFilter ?? request('status_filter', '')) === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ ($statusFilter ?? request('status_filter', '')) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ ($statusFilter ?? request('status_filter', '')) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="col-6 col-md-3">
            <select id="roomTypeFilterSelect" name="room_type_id" class="form-select vd-select">
                <option value="">All Room Types</option>
                @foreach(($roomTypes ?? collect()) as $type)
                    <option value="{{ $type->id }}" {{ (int)($roomTypeFilter ?? request('room_type_id', 0)) === (int)$type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-6 col-md-2">
            <input
                type="date"
                id="checkInFromInput"
                name="check_in_from"
                value="{{ $checkInFrom ?? request('check_in_from', '') }}"
                class="form-control vd-input"
                title="Check-in from"
            >
        </div>

        <div class="col-6 col-md-2">
            <input
                type="date"
                id="checkInToInput"
                name="check_in_to"
                value="{{ $checkInTo ?? request('check_in_to', '') }}"
                class="form-control vd-input"
                title="Check-in to"
            >
        </div>

        <div class="col-12 col-md-2 d-grid">
            <button class="btn vd-btn vd-btn-primary w-100" type="submit">Apply</button>
        </div>
    </form>

    @if(!empty($duplicateCodes))
        <div class="alert alert-warning vd-dup">
            <strong>Duplicate Reference Codes detected:</strong>
            {{ implode(', ', $duplicateCodes) }}
        </div>
    @endif

    {{-- =========================
         MOBILE VIEW (Cards)
         shows on < md
    ========================== --}}
    <div class="d-md-none" id="bookingCards">
        @forelse(($orders ?? collect()) as $order)
            @php
                $statusValue = strtolower((string) data_get($order, 'status', 'pending'));

                $userName  = data_get($order, 'user.name', 'N/A');
                $userEmail = data_get($order, 'user.email');
                $roomName  = data_get($order, 'room.roomtype.name', 'N/A');
                $proofUrl  = $order->proof_image_url;

                $refCode   = data_get($order, 'reference_code', '-');
                $checkIn   = $fmtDate($order->check_in ?? null);
                $checkOut  = $fmtDate($order->check_out ?? null);

                $subTotal  = $peso(data_get($order, 'sub_total', 0));
                $vat       = $peso(data_get($order, 'vat_amount', 0));
                $total     = $peso(data_get($order, 'total_amount', 0));

                $bookedOn  = $fmtDate($order->created_at ?? null);
                $bookedAtT = optional($order->created_at)->format('h:i A');

                $badgeClass = match ($statusValue) {
                    'confirmed' => 'bg-success',
                    'cancelled' => 'bg-secondary',
                    'pending'   => 'bg-dark',
                    default     => 'bg-dark',
                };
                $statusBadgeClass = $statusValue === 'pending' ? 'bg-warning text-dark' : $badgeClass;

                $searchBlob = strtolower(
                    $userName.' '.
                    ($order->customer->phone ?? data_get($order,'customer.phone','')).' '.
                    ($refCode ?? '').' '.
                    ($roomName ?? '').' '.
                    ($userEmail ?? '')
                );
            @endphp

            <div class="vd-card mb-3 booking-card" data-order-id="{{ $order->id }}" data-search="{{ $searchBlob }}">
                <div class="vd-card-body">

                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="flex-grow-1">
                            <div class="fw-semibold">{{ $userName }}</div>
                            <div class="vd-small-muted">{{ $maskEmail($userEmail) }}</div>
                        </div>

                        <div class="text-end">
                            <span class="badge {{ $statusBadgeClass }} js-order-status-badge" data-order-id="{{ $order->id }}">
                                {{ strtoupper($statusValue) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="vd-small-muted mb-1">Room</div>
                        <div class="fw-semibold">{{ $roomName }}</div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <div class="vd-small-muted">Check-In</div>
                            <div class="fw-semibold">{{ $checkIn }}</div>
                        </div>
                        <div class="col-6">
                            <div class="vd-small-muted">Check-Out</div>
                            <div class="fw-semibold">{{ $checkOut }}</div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="vd-small-muted">Reference Code</div>
                        <div class="fw-semibold">{{ $refCode }}</div>
                    </div>

                    <div class="mt-2">
                        <div class="vd-small-muted">Booked On</div>
                        <div class="fw-semibold">{{ $bookedOn }}</div>
                        <div class="vd-small-muted">{{ $bookedAtT ?? '' }}</div>
                    </div>

                    <div class="mt-2">
                        <div class="vd-small-muted">Guest Summary</div>
                        <div class="fw-semibold">{{ $order->guest_total_label }}</div>
                        <div class="vd-small-muted">{{ $order->guest_breakdown }}</div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-4">
                            <div class="vd-small-muted">Subtotal</div>
                            <div class="fw-semibold">{{ $subTotal }}</div>
                        </div>
                        <div class="col-4">
                            <div class="vd-small-muted">VAT</div>
                            <div class="fw-semibold">{{ $vat }}</div>
                        </div>
                        <div class="col-4">
                            <div class="vd-small-muted">Total</div>
                            <div class="fw-bold text-success">{{ $total }}</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="vd-small-muted mb-1">Proof</div>
                        @if($proofUrl !== '')
                            <a href="{{ $proofUrl }}" target="_blank" rel="noopener" class="d-inline-block">
                                <img
                                    src="{{ $proofUrl }}"
                                    alt="Proof"
                                    style="width:90px;height:90px;object-fit:cover;border-radius:12px;"
                                >
                            </a>
                        @else
                            <span class="text-muted">No proof</span>
                        @endif
                    </div>

                    <div class="mt-3 statusCell" data-order-id="{{ $order->id }}" data-layout="mobile">
                        @if($statusValue === 'pending')
                            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="statusForm" data-order-id="{{ $order->id }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="cancel_reason" value="">

                                <select name="status" class="form-select form-select-sm statusSelect vd-select">
                                    <option value="" disabled>Choose...</option>
                                    <option value="pending" selected>Pending</option>
                                    <option value="confirmed">Confirm</option>
                                    <option value="cancelled">Cancel</option>
                                </select>
                            </form>
                        @else
                            @if($statusValue === 'cancelled' && !empty($order->cancel_reason))
                                <div class="small text-muted mt-2">{{ $order->cancel_reason }}</div>
                            @endif
                        @endif
                    </div>

                </div>
            </div>

        @empty
            <div class="text-center text-muted py-4">No bookings found.</div>
        @endforelse
    </div>

    {{-- =========================
         DESKTOP VIEW (Table)
         shows on md+
    ========================== --}}
    <div class="table-responsive d-none d-md-block">
        <table class="vd-table-bs vd-striped align-middle w-100">
            <thead class="vd-thead">
                <tr>
                    <th style="min-width:220px;">Booker</th>
                    <th>Room</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Reference Code</th>
                    <th style="min-width:170px;">Booked On</th>
                    <th style="min-width:220px;">Guest Summary</th>
                    <th>Subtotal</th>
                    <th>VAT</th>
                    <th>Total</th>
                    <th style="min-width:140px;">Proof</th>
                    <th style="min-width:180px;">Status</th>
                </tr>
            </thead>

            <tbody id="bookingTableBody">
            @forelse(($orders ?? collect()) as $order)
                @php
                    $statusValue = strtolower((string) data_get($order, 'status', 'pending'));

                    $userName  = data_get($order, 'user.name', 'N/A');
                    $userEmail = data_get($order, 'user.email');
                    $roomName  = data_get($order, 'room.roomtype.name', 'N/A');
                    $proofUrl  = $order->proof_image_url;

                    $refCode   = data_get($order, 'reference_code', '-');

                    $badgeClass = match ($statusValue) {
                        'confirmed' => 'bg-success',
                        'cancelled' => 'bg-secondary',
                        'pending'   => 'bg-dark',
                        default     => 'bg-dark',
                    };

                    $searchBlob = strtolower(
                        $userName.' '.
                        ($order->customer->phone ?? data_get($order,'customer.phone','')).' '.
                        ($refCode ?? '').' '.
                        ($roomName ?? '').' '.
                        ($userEmail ?? '')
                    );
                @endphp

                <tr class="booking-row" data-order-id="{{ $order->id }}" data-search="{{ $searchBlob }}">
                    <td>
                        {{ $userName }}<br>
                        <small class="text-muted">{{ $maskEmail($userEmail) }}</small>
                    </td>

                    <td>{{ $roomName }}</td>
                    <td>{{ $fmtDate($order->check_in ?? null) }}</td>
                    <td>{{ $fmtDate($order->check_out ?? null) }}</td>
                    <td>{{ $refCode }}</td>

                    <td>
                        @if($order->created_at)
                            <div class="fw-semibold">{{ $order->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td>
                        {{ $order->guest_total_label }}<br>
                        <small class="text-muted">{{ $order->guest_breakdown }}</small>
                    </td>

                    <td>₱{{ number_format((float) data_get($order, 'sub_total', 0), 0) }}</td>
                    <td>₱{{ number_format((float) data_get($order, 'vat_amount', 0), 0) }}</td>
                    <td class="fw-bold text-success">₱{{ number_format((float) data_get($order, 'total_amount', 0), 0) }}</td>

                    <td>
                        @if($proofUrl !== '')
                            <a href="{{ $proofUrl }}" target="_blank" rel="noopener">
                                <img
                                    src="{{ $proofUrl }}"
                                    alt="Proof"
                                    style="width:70px;height:70px;object-fit:cover;border-radius:10px;"
                                >
                            </a>
                        @else
                            <span class="text-muted">No proof</span>
                        @endif
                    </td>

                    <td>
                        <div class="statusCell" data-order-id="{{ $order->id }}" data-layout="desktop">
                        @if($statusValue === 'pending')
                            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="statusForm" data-order-id="{{ $order->id }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="cancel_reason" value="">

                                <select name="status" class="form-select form-select-sm statusSelect vd-select">
                                    <option value="" disabled>Choose...</option>
                                    <option value="pending" selected>Pending</option>
                                    <option value="confirmed">Confirm</option>
                                    <option value="cancelled">Cancel</option>
                                </select>
                            </form>
                        @else
                            <span class="badge {{ $badgeClass }}">{{ strtoupper($statusValue) }}</span>

                            @if($statusValue === 'cancelled' && !empty($order->cancel_reason))
                                <div class="small text-muted mt-1">{{ $order->cancel_reason }}</div>
                            @endif
                        @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center text-muted py-4">No bookings found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination (ONE place only, nicer UI) --}}
    @if(isset($orders) && method_exists($orders, 'links') && $orders->hasPages())
        <div class="vd-card mt-3 vd-pagination-card">
            <div class="vd-card-body py-3 px-3 px-md-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }}
                        of {{ $orders->total() }} bookings
                    </small>

                    <div>
                        {{ $orders->onEachSide(1)->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

<div class="modal fade vd-cancel-modal" id="cancelReasonModal" tabindex="-1" aria-labelledby="cancelReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelReasonModalLabel">Cancel Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="cancelReasonInput" class="form-label mb-2">Reason for cancellation</label>
                <textarea id="cancelReasonInput" class="form-control" rows="4" maxlength="5000" placeholder="Type the cancellation reason..."></textarea>
                <div id="cancelReasonError" class="invalid-feedback d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="cancelReasonConfirm">Confirm Cancel</button>
            </div>
        </div>
    </div>
</div>

<style>
#cancelReasonModal .modal-content {
    border-radius: 16px;
}

#cancelReasonModal .modal-title {
    font-weight: 700;
}

#cancelReasonModal .modal-body .form-control {
    min-height: 130px;
    resize: vertical;
}

#cancelReasonModal .modal-body .form-control::placeholder {
    opacity: .75;
}

.admin-shell.theme-dark #cancelReasonModal .modal-content {
    background: #0b1220;
    color: #e5e7eb;
    border: 1px solid #1f2937;
}

.admin-shell.theme-dark #cancelReasonModal .modal-header,
.admin-shell.theme-dark #cancelReasonModal .modal-footer {
    border-color: #1f2937;
}

.admin-shell.theme-dark #cancelReasonModal .form-control {
    background: #0a1326;
    color: #e2e8f0;
    border-color: #2b3d59;
}

.admin-shell.theme-dark #cancelReasonModal .form-control::placeholder {
    color: #94a3b8;
}

.admin-shell.theme-light #cancelReasonModal .modal-content {
    background: #ffffff;
    color: #0f172a;
    border: 1px solid #e5e7eb;
    box-shadow: 0 24px 70px rgba(15, 23, 42, .18);
}

.admin-shell.theme-light #cancelReasonModal .modal-header,
.admin-shell.theme-light #cancelReasonModal .modal-footer {
    border-color: #e5e7eb;
}

.admin-shell.theme-light #cancelReasonModal .form-control {
    background: #ffffff;
    color: #111827;
    border-color: #d1d5db;
}

.admin-shell.theme-light #cancelReasonModal .form-control::placeholder {
    color: #6b7280;
}

.admin-shell.theme-light #cancelReasonModal .btn-close {
    filter: none;
}

@media print {
    .admin-sidebar,
    .admin-topbar,
    .admin-footer,
    #bookingFilterForm,
    .vd-pagination-card,
    #bookingsPrintBtn,
    .vd-dup,
    #bookingLiveCount {
        display: none !important;
    }

    .admin-main,
    .admin-content,
    .vd-page {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
    }

    .d-md-none#bookingCards {
        display: none !important;
    }

    .table-responsive.d-none.d-md-block {
        display: block !important;
        overflow: visible !important;
    }

    .vd-page .vd-table-bs {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 12px;
    }

    .vd-page .vd-table-bs th,
    .vd-page .vd-table-bs td {
        border: 1px solid #d1d5db !important;
        background: #fff !important;
        color: #000 !important;
    }

    .vd-page .statusForm .statusSelect {
        border: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        -webkit-appearance: none !important;
        appearance: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('bookingFilterForm');
    const refSelect  = document.getElementById('referenceFilterSelect');
    const statusSelect = document.getElementById('statusFilterSelect');
    const roomTypeSelect = document.getElementById('roomTypeFilterSelect');
    const checkInFromInput = document.getElementById('checkInFromInput');
    const checkInToInput = document.getElementById('checkInToInput');

    [refSelect, statusSelect, roomTypeSelect].forEach((sel) => sel?.addEventListener('change', () => {
        const url = new URL(window.location.href);
        url.searchParams.delete('page');
        window.history.replaceState({}, '', url.toString());
        filterForm?.submit();
    }));

    const input = document.getElementById('bookingSearchInput');
    const liveCount = document.getElementById('bookingLiveCount');

    const rows  = Array.from(document.querySelectorAll('.booking-row'));
    const cards = Array.from(document.querySelectorAll('.booking-card'));

    function normalize(s){ return (s || '').toString().toLowerCase().trim(); }

    function setVisible(el, show){
        el.style.display = show ? '' : 'none';
        el.setAttribute('data-visible', show ? '1' : '0');
    }

    function applyFilter(){
        const term = normalize(input?.value);

        let visibleRows = 0;
        let visibleCards = 0;

        rows.forEach(el => {
            const hay = normalize(el.dataset.search || el.innerText);
            const ok = hay.includes(term);
            setVisible(el, ok);
            if (ok) visibleRows++;
        });

        cards.forEach(el => {
            const hay = normalize(el.dataset.search || el.innerText);
            const ok = hay.includes(term);
            setVisible(el, ok);
            if (ok) visibleCards++;
        });

        const totalShown = (rows.length ? visibleRows : visibleCards);
        const totalAll   = (rows.length ? rows.length : cards.length);

        if (liveCount) {
            if (!term) {
                liveCount.classList.add('d-none');
                liveCount.textContent = '';
            } else {
                liveCount.classList.remove('d-none');
                liveCount.textContent = `Showing ${totalShown} result${totalShown === 1 ? '' : 's'} on this page (of ${totalAll}).`;
            }
        }
    }

    if (input) {
        input.addEventListener('input', applyFilter);
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') e.preventDefault();
        });
        applyFilter();
    }

    const exportBtn = document.getElementById('bookingsExportBtn');
    exportBtn?.addEventListener('click', (e) => {
        e.preventDefault();

        const url = new URL(exportBtn.dataset.baseUrl || exportBtn.href, window.location.origin);
        const searchVal = (input?.value || '').trim();
        const refVal = (refSelect?.value || '').trim();
        const statusVal = (statusSelect?.value || '').trim();
        const roomTypeVal = (roomTypeSelect?.value || '').trim();
        const checkInFromVal = (checkInFromInput?.value || '').trim();
        const checkInToVal = (checkInToInput?.value || '').trim();

        if (searchVal) url.searchParams.set('search', searchVal);
        if (refVal) url.searchParams.set('reference_code', refVal);
        if (statusVal) url.searchParams.set('status_filter', statusVal);
        if (roomTypeVal) url.searchParams.set('room_type_id', roomTypeVal);
        if (checkInFromVal) url.searchParams.set('check_in_from', checkInFromVal);
        if (checkInToVal) url.searchParams.set('check_in_to', checkInToVal);

        window.location.href = url.toString();
    });

    const cancelModalEl = document.getElementById('cancelReasonModal');
    const cancelReasonInput = document.getElementById('cancelReasonInput');
    const cancelReasonError = document.getElementById('cancelReasonError');
    const cancelReasonConfirm = document.getElementById('cancelReasonConfirm');
    const cancelModal = (window.bootstrap && cancelModalEl) ? new window.bootstrap.Modal(cancelModalEl) : null;

    let activeCancelContext = null;
    let cancelSubmitting = false;

    function escapeHtml(value) {
        return (value || '')
            .toString()
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#39;');
    }

    function statusLabel(status) {
        return (status || '').toString().toUpperCase();
    }

    function statusBadgeClass(status) {
        const key = (status || '').toString().toLowerCase();
        if (key === 'confirmed') return 'bg-success';
        if (key === 'cancelled') return 'bg-secondary';
        if (key === 'pending') return 'bg-warning text-dark';
        return 'bg-dark';
    }

    function renderResolvedStatus(layout, status, cancelReason) {
        const key = (status || '').toString().toLowerCase();
        const marginClass = layout === 'mobile' ? 'mt-2' : 'mt-1';

        let html = `<span class="badge ${statusBadgeClass(key)}">${statusLabel(key)}</span>`;
        if (key === 'confirmed' && layout === 'mobile') {
            html += '<div class="small text-success mt-2">Booking confirmed.</div>';
        }
        if (key === 'cancelled' && cancelReason) {
            html += `<div class="small text-muted ${marginClass}">${escapeHtml(cancelReason)}</div>`;
        }

        return html;
    }

    function updateStatusBadges(orderId, status) {
        if (!orderId) return;
        document.querySelectorAll(`.js-order-status-badge[data-order-id="${orderId}"]`).forEach(badge => {
            badge.className = `badge ${statusBadgeClass(status)} js-order-status-badge`;
            badge.textContent = statusLabel(status);
        });
    }

    function updateStatusCells(orderId, status, cancelReason) {
        if (!orderId) return;
        document.querySelectorAll(`.statusCell[data-order-id="${orderId}"]`).forEach(cell => {
            const layout = cell.dataset.layout || 'desktop';
            cell.innerHTML = renderResolvedStatus(layout, status, cancelReason);
        });
    }

    function applyServerUpdate(payload, fallbackOrderId, fallbackStatus, fallbackReason = '') {
        const resultOrder = payload?.order || {};
        const orderId = `${resultOrder.id ?? fallbackOrderId ?? ''}`;
        const status = (resultOrder.status || fallbackStatus || 'pending').toString().toLowerCase();
        const cancelReason = `${resultOrder.cancel_reason ?? fallbackReason ?? ''}`;

        if (orderId) {
            updateStatusBadges(orderId, status);
            updateStatusCells(orderId, status, cancelReason);
        }

        const autoCancelled = Array.isArray(payload?.meta?.auto_cancelled_orders)
            ? payload.meta.auto_cancelled_orders
            : [];

        autoCancelled.forEach(item => {
            const autoId = `${item?.id ?? ''}`;
            if (!autoId) return;
            const autoStatus = (item?.status || 'cancelled').toString().toLowerCase();
            const autoReason = `${item?.cancel_reason ?? ''}`;

            updateStatusBadges(autoId, autoStatus);
            updateStatusCells(autoId, autoStatus, autoReason);
        });
    }

    async function requestStatusUpdate(form, status, cancelReason = '') {
        const formData = new FormData(form);
        formData.set('_method', 'PUT');
        formData.set('status', status);
        formData.set('cancel_reason', status === 'cancelled' ? cancelReason : '');

        const response = await fetch(form.action, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });

        const payload = await response.json().catch(() => ({}));
        if (!response.ok) {
            throw new Error(payload.message || 'Unable to update this booking right now.');
        }

        return payload;
    }

    async function submitStatusUpdate(context, status, cancelReason = '') {
        const form = context?.form;
        const select = context?.select;
        const orderId = context?.orderId;

        if (!form) {
            throw new Error('Missing status form.');
        }

        if (select) {
            select.disabled = true;
        }

        try {
            const payload = await requestStatusUpdate(form, status, cancelReason);
            applyServerUpdate(payload, orderId, status, cancelReason);
            return payload;
        } catch (error) {
            if (select) {
                select.disabled = false;
                select.value = context?.originalValue || 'pending';
            }
            throw error;
        }
    }

    function setCancelError(message) {
        if (!cancelReasonError || !cancelReasonInput) return;

        if (!message) {
            cancelReasonInput.classList.remove('is-invalid');
            cancelReasonError.classList.add('d-none');
            cancelReasonError.textContent = '';
            return;
        }

        cancelReasonInput.classList.add('is-invalid');
        cancelReasonError.classList.remove('d-none');
        cancelReasonError.textContent = message;
    }

    cancelModalEl?.addEventListener('shown.bs.modal', () => {
        cancelReasonInput?.focus();
    });

    cancelModalEl?.addEventListener('hidden.bs.modal', () => {
        if (!cancelSubmitting && activeCancelContext?.select) {
            activeCancelContext.select.value = activeCancelContext.originalValue || 'pending';
            if (activeCancelContext.hiddenReason) activeCancelContext.hiddenReason.value = '';
        }

        setCancelError('');
        cancelSubmitting = false;
        activeCancelContext = null;
    });

    document.querySelectorAll('.statusSelect').forEach(select => {
        select.addEventListener('change', async () => {
            const statusForm = select.closest('form.statusForm');
            if (!statusForm) return;

            const hiddenReason = statusForm.querySelector('input[name="cancel_reason"]');
            const statusValue = (select.value || '').trim().toLowerCase();
            const context = {
                form: statusForm,
                select,
                hiddenReason,
                originalValue: 'pending',
                orderId: statusForm.dataset.orderId || statusForm.closest('[data-order-id]')?.dataset.orderId || ''
            };

            if (statusValue === 'cancelled') {
                if (!cancelModal) {
                    select.value = 'pending';
                    window.alert('Cancellation modal failed to load. Please refresh and try again.');
                    return;
                }

                activeCancelContext = context;
                if (cancelReasonInput) {
                    cancelReasonInput.value = '';
                    cancelReasonInput.classList.remove('is-invalid');
                }
                setCancelError('');
                cancelModal.show();
                return;
            }

            if (statusValue !== 'confirmed') {
                select.value = 'pending';
                return;
            }

            if (hiddenReason) hiddenReason.value = '';

            try {
                await submitStatusUpdate(context, 'confirmed', '');
            } catch (error) {
                window.alert(error.message || 'Confirm failed. Please try again.');
            }
        });
    });

    cancelReasonConfirm?.addEventListener('click', async () => {
        if (!activeCancelContext) return;

        const reason = (cancelReasonInput?.value || '').trim();
        if (!reason) {
            setCancelError('Please provide a cancellation reason.');
            return;
        }

        setCancelError('');

        const originalButtonText = cancelReasonConfirm.textContent;
        cancelSubmitting = true;
        cancelReasonConfirm.disabled = true;
        cancelReasonConfirm.textContent = 'Saving...';

        try {
            await submitStatusUpdate(activeCancelContext, 'cancelled', reason);
            activeCancelContext = null;
            cancelModal.hide();
        } catch (error) {
            setCancelError(error.message || 'Cancellation failed. Please try again.');
            cancelSubmitting = false;
        } finally {
            cancelReasonConfirm.disabled = false;
            cancelReasonConfirm.textContent = originalButtonText;
        }
    });
});
</script>
@endsection
