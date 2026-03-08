@extends('admin.layouts.app')

@section('content')
<div class="py-3 vd-page">

    <div class="vd-card">
        <div class="vd-card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="mb-0">Reference Codes</h2>
                <small class="vd-small-muted">Analytics and usage tracking</small>
            </div>

            <!-- Export Button -->
            <a href="{{ route('admin.references.export') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
            </a>
        </div>

        <div class="vd-card-body">

            <!-- Search & Filter -->
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 mb-4">
                <div class="col-12 col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control vd-input"
                        placeholder="Search name, phone, reference code..."
                        value="{{ $search ?? '' }}"
                    >
                </div>

                <div class="col-12 col-md-4">
                    <select name="reference_code" class="form-select vd-select">
                        <option value="">Filter by reference code</option>

                        @foreach(($referencestats ?? collect()) as $ref)
                            <option value="{{ $ref->reference_code }}"
                                {{ ($filterCode ?? '') == $ref->reference_code ? 'selected' : '' }}>
                                {{ $ref->reference_code }} ({{ $ref->total }} uses)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4 d-grid">
                    <button class="btn vd-btn vd-btn-primary">Apply</button>
                </div>
            </form>

            <!-- Reference Ranking Table -->
            <h4 class="mb-3">Top Reference Codes</h4>
            <div class="table-responsive mb-4">
                <table class="table vd-table-bs align-middle mb-0">
                    <thead class="vd-thead">
                        <tr>
                            <th>Reference Code</th>
                            <th style="width:180px;">Total Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($referencestats ?? collect()) as $stats)
                            <tr>
                                <td class="fw-semibold">{{ $stats->reference_code }}</td>
                                <td class="fw-bold">{{ $stats->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center vd-empty py-3">
                                    No reference stats found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Main Table -->
            <div class="table-responsive">
                <table class="table vd-table-bs vd-striped align-middle mb-0">
                    <thead class="vd-thead">
                        <tr>
                            <th style="min-width:180px;">Name</th>
                            <th style="min-width:140px;">Phone</th>
                            <th style="min-width:160px;">Room</th>
                            <th style="min-width:120px;">Check In</th>
                            <th style="min-width:120px;">Check Out</th>
                            <th style="min-width:140px;">Total</th>
                            <th style="min-width:160px;">Reference Code</th>
                            <th style="min-width:160px;">Booked On</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse(($orders ?? collect()) as $order)
                            @php
                                $code = $order->reference_code ?? 'None';
                                $isDup = in_array($code, ($duplicateCodes ?? []), true);

                                $price = (float) optional($order->room)->price;
                                $days  = (int) ($order->stayDays ?? 0);
                                $total = $price * $days;
                            @endphp

                            <tr>
                                <td>{{ optional($order->customer)->name ?? 'N/A' }}</td>
                                <td>{{ optional($order->customer)->phone ?? 'N/A' }}</td>
                                <td>{{ optional(optional($order->room)->roomtype)->name ?? 'N/A' }}</td>
                                <td>{{ $order->check_in ?? '-' }}</td>
                                <td>{{ $order->check_out ?? '-' }}</td>
                                <td class="fw-semibold">₱{{ number_format($total, 2) }}</td>

                                <!-- Highlight duplicates -->
                                <td class="{{ $isDup ? 'vd-dup fw-bold' : 'fw-bold' }}">
                                    {{ $code }}
                                </td>

                                <td>{{ optional($order->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center vd-empty-danger fw-bold py-3">
                                    No records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                @if(isset($orders) && method_exists($orders, 'links'))
                    {{ $orders->withQueryString()->links() }}
                @endif
            </div>

        </div>
    </div>

</div>
@endsection