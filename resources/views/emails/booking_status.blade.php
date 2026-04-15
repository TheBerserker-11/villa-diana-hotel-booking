<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Status Update</title>
</head>
<body style="margin:0;padding:0;background:#f4f6fb;font-family:Arial,Helvetica,sans-serif;color:#0f172b;">
@php
    $status = strtolower((string) ($order->status ?? ''));
    $guestName = trim((string) data_get($order, 'user.name', 'Guest'));
    $roomName = trim((string) data_get($order, 'room.roomType.name', 'Room Reservation'));
    $referenceCode = trim((string) ($order->reference_code ?? 'N/A'));
    $checkIn = optional($order->check_in)->format('F d, Y');
    $checkOut = optional($order->check_out)->format('F d, Y');
    $nights = max(1, (int) ($order->nights ?? 1));
    $guestSummary = trim((string) ($order->guest_summary ?? ''));
    $supportEmail = config('mail.from.address', 'villadianahotel@gmail.com');
    $supportName = config('mail.from.name', 'Villa Diana Hotel');
    $logoUrl = rtrim(config('app.url'), '/') . '/img/logo/logo.png';

    $statusLabel = match ($status) {
        'confirmed' => 'Confirmed',
        'cancelled' => 'Cancelled',
        default => ucfirst($status ?: 'Updated'),
    };

    $statusBadgeBg = match ($status) {
        'confirmed' => '#e8f8ef',
        'cancelled' => '#fdecec',
        default => '#fff7e8',
    };

    $statusBadgeColor = match ($status) {
        'confirmed' => '#1f8f5f',
        'cancelled' => '#c13d3d',
        default => '#b7791f',
    };

    $accentColor = match ($status) {
        'confirmed' => '#1f8f5f',
        'cancelled' => '#d97706',
        default => '#FEA116',
    };

    $headline = match ($status) {
        'confirmed' => 'Your Booking Is Confirmed',
        'cancelled' => 'Your Booking Could Not Be Completed',
        default => 'Booking Status Update',
    };

    $lead = match ($status) {
        'confirmed' => 'We have received your booking details and your stay is now reserved.',
        'cancelled' => 'We are sorry, but this reservation has been cancelled. You can review the details below and book again anytime.',
        default => 'There is an update on your booking. You can review the latest details below.',
    };

    $ctaUrl = $status === 'cancelled' ? route('rooms.index') : route('orders.index');
    $ctaLabel = $status === 'cancelled' ? 'Book Again' : 'View My Booking';
    $secondaryUrl = route('contact');
    $secondaryLabel = 'Contact Support';
@endphp

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb;padding:28px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:680px;">
                <tr>
                    <td>
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#0f172b;border-radius:24px 24px 0 0;overflow:hidden;">
                            <tr>
                                <td style="height:6px;background:#FEA116;font-size:0;line-height:0;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="padding:28px 28px 30px 28px;background:linear-gradient(135deg, #0f172b 0%, #17324f 100%);">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="vertical-align:top;">
                                                <div style="display:inline-block;padding:7px 12px;border:1px solid rgba(254,161,22,.35);border-radius:999px;color:#f8d494;font-size:11px;letter-spacing:2px;font-weight:700;text-transform:uppercase;">
                                                    Villa Diana Hotel
                                                </div>
                                                <h1 style="margin:18px 0 10px 0;color:#ffffff;font-size:32px;line-height:1.15;font-weight:800;">
                                                    {{ $headline }}
                                                </h1>
                                                <p style="margin:0;color:#d8e2f0;font-size:15px;line-height:1.65;max-width:420px;">
                                                    {{ $lead }}
                                                </p>
                                            </td>
                                            <td align="right" style="vertical-align:top;padding-left:18px;">
                                                <img
                                                    src="{{ $logoUrl }}"
                                                    alt="Villa Diana Hotel"
                                                    width="62"
                                                    height="62"
                                                    style="display:block;border-radius:16px;background:rgba(255,255,255,.1);padding:8px;"
                                                >
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#ffffff;border:1px solid #e8edf5;border-top:0;border-radius:0 0 24px 24px;overflow:hidden;box-shadow:0 18px 45px rgba(15,23,42,.08);">
                            <tr>
                                <td style="padding:28px 28px 10px 28px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="font-size:18px;line-height:1.6;color:#0f172b;font-weight:700;">
                                                Hello {{ $guestName }},
                                            </td>
                                            <td align="right" style="vertical-align:top;padding-left:16px;">
                                                <span style="display:inline-block;padding:8px 14px;border-radius:999px;background:{{ $statusBadgeBg }};color:{{ $statusBadgeColor }};font-size:12px;font-weight:800;letter-spacing:.3px;text-transform:uppercase;">
                                                    {{ $statusLabel }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:4px 28px 0 28px;color:#475569;font-size:15px;line-height:1.7;">
                                    Your reservation details are listed below so you can quickly review your latest booking update.
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:22px 28px 0 28px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e7edf5;border-radius:18px;background:#fbfcfe;">
                                        <tr>
                                            <td style="padding:20px 20px 8px 20px;">
                                                <div style="font-size:13px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#64748b;">
                                                    Booking Summary
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0 20px 20px 20px;">
                                                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#64748b;font-size:13px;">Reference Code</td>
                                                        <td align="right" style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#0f172b;font-size:15px;font-weight:800;">{{ $referenceCode }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#64748b;font-size:13px;">Room</td>
                                                        <td align="right" style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#0f172b;font-size:15px;font-weight:700;">{{ $roomName }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#64748b;font-size:13px;">Check-in</td>
                                                        <td align="right" style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#0f172b;font-size:15px;font-weight:700;">{{ $checkIn ?: 'TBD' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#64748b;font-size:13px;">Check-out</td>
                                                        <td align="right" style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#0f172b;font-size:15px;font-weight:700;">{{ $checkOut ?: 'TBD' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#64748b;font-size:13px;">Stay</td>
                                                        <td align="right" style="padding:12px 0;border-bottom:1px solid #e7edf5;color:#0f172b;font-size:15px;font-weight:700;">{{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}</td>
                                                    </tr>
                                                    @if($guestSummary !== '')
                                                        <tr>
                                                            <td style="padding:12px 0;color:#64748b;font-size:13px;">Guests</td>
                                                            <td align="right" style="padding:12px 0;color:#0f172b;font-size:15px;font-weight:700;">{{ $guestSummary }}</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:22px 28px 0 28px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-radius:18px;background:{{ $status === 'confirmed' ? '#effaf4' : ($status === 'cancelled' ? '#fff7ed' : '#fff9e8') }};border:1px solid {{ $status === 'confirmed' ? '#cdeed9' : ($status === 'cancelled' ? '#fed7aa' : '#fde68a') }};">
                                        <tr>
                                            <td style="padding:20px 20px 18px 20px;color:#334155;font-size:15px;line-height:1.7;">
                                                @if($status === 'confirmed')
                                                    <div style="font-size:18px;font-weight:800;color:#166534;margin-bottom:8px;">
                                                        Reservation secured
                                                    </div>
                                                    Your payment proof has been reviewed and your booking is now confirmed. Please keep your reference code available when you arrive at the hotel.
                                                @elseif($status === 'cancelled')
                                                    <div style="font-size:18px;font-weight:800;color:#b45309;margin-bottom:8px;">
                                                        Reservation cancelled
                                                    </div>
                                                    This booking has been cancelled. If you'd like, you can submit a new reservation right away or contact our team for assistance.
                                                    @if(!empty($order->cancel_reason))
                                                        <div style="margin-top:14px;padding:14px 16px;background:#ffffff;border-radius:14px;border:1px solid #fed7aa;">
                                                            <div style="font-size:12px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#c2410c;margin-bottom:6px;">
                                                                Reason
                                                            </div>
                                                            <div style="color:#7c2d12;font-weight:700;">
                                                                {{ $order->cancel_reason }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div style="font-size:18px;font-weight:800;color:#92400e;margin-bottom:8px;">
                                                        Booking updated
                                                    </div>
                                                    We have recorded a change to your reservation. Please review the latest details and reach out if you need any help.
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td align="center" style="padding:28px 28px 14px 28px;">
                                    <a
                                        href="{{ $ctaUrl }}"
                                        style="display:inline-block;background:{{ $accentColor }};color:#ffffff;text-decoration:none;padding:14px 24px;border-radius:14px;font-size:14px;font-weight:800;letter-spacing:.2px;box-shadow:0 10px 24px rgba(15,23,42,.14);"
                                    >
                                        {{ $ctaLabel }}
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td align="center" style="padding:0 28px 12px 28px;color:#64748b;font-size:13px;line-height:1.6;">
                                    Need help? Contact us at
                                    <a href="mailto:{{ $supportEmail }}" style="color:#0f172b;font-weight:700;text-decoration:none;">{{ $supportEmail }}</a>
                                    or
                                    <a href="{{ $secondaryUrl }}" style="color:#0f172b;font-weight:700;text-decoration:none;">{{ $secondaryLabel }}</a>.
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:14px 28px 0 28px;">
                                    <div style="height:1px;background:#e9eef5;"></div>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:18px 28px 26px 28px;color:#64748b;font-size:13px;line-height:1.7;">
                                    <div style="color:#0f172b;font-size:15px;font-weight:700;margin-bottom:4px;">Thank you,</div>
                                    <div>{{ $supportName }}</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:16px 20px 0 20px;color:#94a3b8;font-size:12px;line-height:1.6;">
                        &copy; {{ date('Y') }} {{ $supportName }}. This is an automated booking update email.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>

