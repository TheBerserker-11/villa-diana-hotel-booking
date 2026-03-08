@component('mail::message')

Hi {{ $order->user->name }},

Your booking for **{{ $order->room->roomType->name ?? 'Room' }}**  
from **{{ $order->check_in->format('F d, Y h:i A') }}**  
to **{{ $order->check_out->format('F d, Y h:i A') }}**  
has been **{{ ucfirst($order->status) }}**.

Reference Code: **{{ $order->reference_code }}**

@if($order->status === 'confirmed')

Thank you for your payment via **GCash**.  
Your booking is now **confirmed** and reserved for your stay. We look forward to welcoming you!

@endif


@if($order->status === 'cancelled')


We're sorry to inform you that your booking has been cancelled.

@if(!empty($order->cancel_reason))
**{{ $order->cancel_reason }}**
@endif

If you have questions or would like to rebook, please contact us at  
**villadianahotel@gmail.com**

@endif

Thanks,<br>
Villa Diana Hotel
@endcomponent
