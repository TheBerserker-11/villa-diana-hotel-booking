@php
    $status = strtolower((string) ($order->status ?? ''));
    $guestName = trim((string) data_get($order, 'user.name', 'Guest'));
    $roomName = trim((string) data_get($order, 'room.roomType.name', 'Room Reservation'));
    $referenceCode = trim((string) ($order->reference_code ?? 'N/A'));
    $checkIn = optional($order->check_in)->format('F d, Y');
    $checkOut = optional($order->check_out)->format('F d, Y');
    $supportEmail = config('mail.from.address', 'villadianahotel@gmail.com');
    $ctaUrl = $status === 'cancelled' ? route('rooms.index') : route('orders.index');
    $ctaLabel = $status === 'cancelled' ? 'Book Again' : 'View My Booking';
@endphp
Hello {{ $guestName }},

This is an update for your Villa Diana Hotel booking.

Status: {{ ucfirst($status ?: 'updated') }}
Reference Code: {{ $referenceCode }}
Room: {{ $roomName }}
Check-in: {{ $checkIn ?: 'TBD' }}
Check-out: {{ $checkOut ?: 'TBD' }}

@if($status === 'confirmed')
Your reservation is now confirmed and reserved for your stay.
@elseif($status === 'cancelled')
Your reservation has been cancelled.
@if(!empty($order->cancel_reason))
Reason: {{ $order->cancel_reason }}
@endif
@else
Please review the latest booking details.
@endif

{{ $ctaLabel }}: {{ $ctaUrl }}

Questions? Contact us at {{ $supportEmail }}.

Thank you,
Villa Diana Hotel
