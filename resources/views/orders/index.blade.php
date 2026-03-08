@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@push('styles')
<style>
    .vd-bookings-shell{
        border-radius: 20px;
    }

    .vd-bookings-table{
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 0;
    }

    .vd-bookings-table thead th{
        background: #0f172b;
        color: #fff;
        border-bottom: 0;
        white-space: nowrap;
    }

    .vd-bookings-table tbody td{
        vertical-align: middle;
    }

    .vd-bookings-table tbody tr:nth-child(even) td{
        background: #f8fafc;
    }

    @media (max-width: 767.98px){
        .vd-bookings-shell{
            padding: 14px !important;
            border-radius: 16px;
        }

        .vd-bookings-table,
        .vd-bookings-table tbody,
        .vd-bookings-table tr,
        .vd-bookings-table td{
            display: block;
            width: 100%;
        }

        .vd-bookings-table{
            border: 0;
            border-radius: 0;
            background: transparent;
        }

        .vd-bookings-table thead{
            display: none;
        }

        .vd-bookings-table tbody tr{
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 10px 12px;
            margin-bottom: 10px;
            box-shadow: 0 8px 20px rgba(15,23,43,.06);
        }

        .vd-bookings-table tbody tr:nth-child(even) td{
            background: transparent;
        }

        .vd-bookings-table tbody td{
            border: 0;
            padding: 6px 0;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .vd-bookings-table tbody td::before{
            content: attr(data-label);
            font-weight: 700;
            color: #334155;
            min-width: 108px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-start mb-4">
            <h2 class="mb-0">My Bookings</h2>
            <p class="text-muted mb-0">View your reservations and their status.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow vd-bookings-shell p-3 p-md-4">
            @if($orders->count() === 0)
                <div class="text-center py-5">
                    <h5 class="mb-2">No bookings yet</h5>
                    <p class="text-muted mb-4">You haven’t made any reservations. Ready to book a room?</p>
                    <a href="{{ route('rooms.index') }}" class="btn btn-primary">Browse Rooms</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle vd-bookings-table">
                        <thead class="table-dark">
                            <tr>
                                <th>Room</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Guests</th>
                                <th>Status</th>
                                <th>Reference Code</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $guests = ($order->adults ?? 0) + ($order->children ?? 0) + ($order->infants ?? 0);

                                    $badgeClass = 'bg-warning text-dark';
                                    if ($order->status === 'confirmed') $badgeClass = 'bg-success';
                                    if ($order->status === 'cancelled') $badgeClass = 'bg-secondary';
                                @endphp

                                <tr>
                                    <td class="fw-semibold" data-label="Room">
                                        {{ $order->room->roomtype->name ?? 'Room' }}
                                    </td>
                                    <td data-label="Check-in">{{ \Carbon\Carbon::parse($order->check_in)->format('M d, Y') }}</td>
                                    <td data-label="Check-out">{{ \Carbon\Carbon::parse($order->check_out)->format('M d, Y') }}</td>
                                    <td data-label="Guests">{{ $guests }} {{ $guests == 1 ? 'guest' : 'guests' }}</td>
                                    <td data-label="Status">
                                        <span class="badge {{ $badgeClass }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>
                                    <td data-label="Reference">{{ $order->reference_code ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
