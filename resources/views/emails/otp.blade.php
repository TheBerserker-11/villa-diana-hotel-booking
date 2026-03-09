<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>OTP Verification</title>
</head>

<body style="margin:0; padding:0; background:#f4f6fb;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb; padding:40px 12px;">
<tr>
<td align="center">

<table width="100%" cellpadding="0" cellspacing="0"
       style="max-width:520px; background:#ffffff; border-radius:16px; overflow:hidden;
              box-shadow:0 10px 30px rgba(0,0,0,.08);
              font-family:Arial, Helvetica, sans-serif;">

    <tr>
        <td style="background:#FEA116; height:6px;"></td>
    </tr>

    <tr>
        <td align="center" style="padding:28px 20px 10px 20px;">
            <img src="https://villadiana.shop/img/logo/logo.png"
                 alt="Villa Diana Hotel"
                 width="130"
                 style="display:block; max-width:130px; height:auto; border:0; outline:none; text-decoration:none;">
        </td>
    </tr>

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

    <tr>
        <td style="padding:0 40px 30px 40px; color:#374151; font-size:15px; line-height:1.6;">

            <h2 style="margin-top:0; margin-bottom:12px; color:#0F172B; font-size:20px;">
                OTP Verification
            </h2>

            <p style="margin:0 0 14px 0;">
                Hello,
            </p>

            <p style="margin:0 0 16px 0;">
                Use the verification code below to complete your registration. This code will expire in <strong>5 minutes</strong>.
            </p>

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
                    color:#0F172B;
                    display:inline-block;">
                    {{ $otp }}
                </span>

            </div>

            <p style="margin:0 0 14px 0; color:#475569;">
                Please do not share this code with anyone for your account security.
            </p>

            <p style="margin:0; color:#64748b;">
                If you did not request this verification, you can safely ignore this email.
            </p>

            <p style="margin-top:24px; color:#475569;">
                Regards,<br>
                <strong>Villa Diana Hotel</strong>
            </p>

        </td>
    </tr>

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
