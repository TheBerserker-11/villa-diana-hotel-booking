<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>OTP Verification</title>
</head>

<body style="margin:0; padding:0; background:#f4f6fb;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb; padding:40px 0;">
<tr>
<td align="center">

<table width="520" cellpadding="0" cellspacing="0"
       style="background:#ffffff; border-radius:16px; overflow:hidden;
              box-shadow:0 10px 30px rgba(0,0,0,.08);
              font-family:Arial, Helvetica, sans-serif;">

    <!-- GOLD HEADER STRIP -->
    <tr>
        <td style="background:#FEA116; height:6px;"></td>
    </tr>

    <!-- LOGO -->
    <tr>
        <td align="center" style="padding:28px 20px 10px 20px;">
            <img src="{{ asset('img/logo.png') }}"
                 alt="Villa Diana Hotel"
                 width="120"
                 style="display:block;">
        </td>
    </tr>

    <!-- TITLE -->
    <tr>
        <td align="center" style="padding-bottom:22px;">
            <h1 style="margin:0; color:#0F172B; font-size:22px; font-weight:800;">
                Villa Diana Hotel
            </h1>
            <p style="margin:6px 0 0 0; color:#6b7280; font-size:14px;">
                Secure Account Verification
            </p>
        </td>
    </tr>

    <!-- EMAIL BODY -->
    <tr>
        <td style="padding:0 40px 30px 40px; color:#374151; font-size:15px; line-height:1.6;">

            <h2 style="margin-top:0; color:#0F172B;">OTP Verification</h2>

            <p>
                Hello 👋,
            </p>

            <p>
                Use the verification code below to complete your registration.
                This code will expire in <strong>5 minutes</strong>.
            </p>

            <!-- OTP BOX -->
            <div style="
                margin:30px 0;
                padding:18px;
                background:#f8fafc;
                border-radius:12px;
                text-align:center;
                border:1px dashed #e5e7eb;">

                <span style="
                    font-size:34px;
                    letter-spacing:8px;
                    font-weight:800;
                    color:#0F172B;">
                    {{ $otp }}
                </span>

            </div>

            <p style="margin-top:25px;">
                If you did not request this, you can safely ignore this email.
            </p>

            <p style="margin-top:25px;">
                — Villa Diana Hotel Team
            </p>

        </td>
    </tr>

    <!-- FOOTER -->
    <tr>
        <td align="center"
            style="padding:18px; font-size:12px; color:#9ca3af; border-top:1px solid #f1f5f9;">
            © {{ date('Y') }} Villa Diana Hotel • All rights reserved
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>