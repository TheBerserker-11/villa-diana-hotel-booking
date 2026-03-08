@extends('layouts.app')

@section('header')
    @include('layouts.header')
@endsection

@section('content')
<div class="container mt-3 mb-4">
        <a href="{{ route('rooms.index') }}" class="btn-back">← Back</a>
</div>

    <div class="card">
        <div class="card-header">
            <h2>My Booking</h2>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Room Name</th>
                    <th scope="col">Check in</th>
                    <th scope="col">Check out</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Reference Code</th> 
                    <th scope="col">Booked on</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>

                <tbody>
                        @foreach($orders as $order)
        <tr>
            <td>{{ $order->room->roomType->name ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($order->check_in)->format('Y-m-d') }}</td>
            <td>{{ \Carbon\Carbon::parse($order->check_out)->format('Y-m-d') }}</td>

            <td>
                @php
                    $totalGuests = $order->adults + $order->children + $order->infants + $order->pets;
                @endphp
                {{ $totalGuests }} guests<br>
                <small>{{ $order->adults }} Adults, {{ $order->children }} Children, {{ $order->infants }} Infants, {{ $order->pets }} Pets</small>
            </td>
            <td class="fw-bold text-primary">
                            {{ $order->reference_code ?? 'None' }}
                        </td>
                        <td>{{ $order->created_at }}</td>
            <td>{{ ucfirst($order->status) }}</td>
        </tr>
        @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('sections.newsletter')
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
