@extends('layouts.app')

@section('title', 'Admin Report')

@section('content')
<div class="report-container">

    <h1 class="title">Admin Report</h1>

    <div class="stats-grid">
        <div class="card">
            <h2>Total Rooms</h2>
            <p>{{ $totalRooms }}</p>
        </div>

        <div class="card">
            <h2>Total Guests</h2>
            <p>{{ $totalGuests }}</p>
        </div>

        <div class="card">
            <h2>Total Bookings</h2>
            <p>{{ $totalBookings }}</p>
        </div>

        <div class="card">
            <h2>Occupied Rooms Today</h2>
            <p>{{ $occupiedRooms }}</p>
        </div>

        <div class="card">
            <h2>Occupancy Rate</h2>
            <p>{{ $occupancyRate }}%</p>
        </div>
    </div>

    <h2 class="sub-title">Upcoming Bookings</h2>

    @if($upcomingBookings->isEmpty())
        <p>No upcoming bookings.</p>
    @else
        <table class="report-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                </tr>
            </thead>
            <tbody>
                @foreach($upcomingBookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->guest->name ?? 'N/A' }}</td>
                    <td>{{ $booking->room->room_number ?? 'N/A' }}</td>
                    <td>{{ $booking->check_in }}</td>
                    <td>{{ $booking->check_out }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

@push('css')
<style>
    .report-container {
        padding: 20px;
    }

    .title {
        font-size: 28px;
        margin-bottom: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }

    .card {
        background: white;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }

    .card h2 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 22px;
        font-weight: bold;
    }

    .sub-title {
        margin-top: 30px;
        margin-bottom: 10px;
        font-size: 22px;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
    }

    .report-table th, .report-table td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    .report-table th {
        background: #eee;
    }
</style>
@endpush
