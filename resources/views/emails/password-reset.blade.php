<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>
</head>
<body style="margin:0;padding:0;background:#f6f7fb;font-family:Arial,Helvetica,sans-serif;color:#0f172b;">

  <!-- Wrapper -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f7fb;padding:28px 12px;">
    <tr>
      <td align="center">

        <!-- Card -->
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;background:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 18px 45px rgba(0,0,0,.10);">
          
          <!-- Header -->
          <tr>
            <td style="background:#013C2B;padding:22px 26px;color:#ffffff;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="vertical-align:middle;">
                    <div style="font-weight:800;font-size:18px;letter-spacing:.2px;">
                      Villa Diana Hotel
                    </div>
                    <div style="opacity:.85;font-size:13px;margin-top:4px;">
                      Password Reset Request
                    </div>
                  </td>
                  <td align="right" style="vertical-align:middle;">
                    <!-- Optional logo -->
                    <img src="{{ config('app.url') }}/img/logo/logo.png"
                        alt="Villa Diana Hotel"
                        width="44"
                        height="44"
                        style="display:block;border-radius:12px;background:rgba(255,255,255,.12);padding:6px;">
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:26px 26px 18px 26px;">
              <h2 style="margin:0 0 10px 0;font-size:22px;line-height:1.25;">
                Hello!
              </h2>

              <p style="margin:0 0 14px 0;color:#475569;font-size:14px;line-height:1.6;">
                We received a request to reset the password for your account.
                Click the button below to create a new password.
              </p>

              <!-- Button -->
              <div style="text-align:center;margin:18px 0 18px 0;">
                <a href="{{ $url }}"
                   style="display:inline-block;background:#FEA116;color:#ffffff;text-decoration:none;
                          padding:12px 18px;border-radius:14px;font-weight:800;font-size:14px;
                          box-shadow:0 10px 26px rgba(254,161,22,.25);">
                  Reset Password
                </a>
              </div>

              <p style="margin:0 0 10px 0;color:#475569;font-size:13px;line-height:1.6;">
                This password reset link will expire in <strong>{{ $expire }}</strong>.
              </p>

              <p style="margin:0;color:#64748b;font-size:13px;line-height:1.6;">
                If you did not request a password reset, you can safely ignore this email.
              </p>

              <!-- Divider -->
              <div style="height:1px;background:#eef2f7;margin:18px 0;"></div>

              <p style="margin:0 0 8px 0;color:#475569;font-size:12.5px;line-height:1.6;">
                If the button doesn’t work, copy and paste this link into your browser:
              </p>

              <p style="margin:0;word-break:break-all;font-size:12.5px;line-height:1.6;">
                <a href="{{ $url }}" style="color:#0d6efd;text-decoration:underline;">
                  {{ $url }}
                </a>
              </p>

              <p style="margin:18px 0 0 0;color:#475569;font-size:13px;">
                Regards,<br>
                <strong>Villa Diana Hotel</strong>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:14px 20px;background:#0f172b;color:#cbd5e1;text-align:center;font-size:12px;">
              © {{ date('Y') }} Villa Diana Hotel. All rights reserved.
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>