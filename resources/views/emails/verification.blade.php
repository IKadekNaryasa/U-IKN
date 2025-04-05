<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Account Created</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; color: #333;">

    <table style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <tr>
            <td>
                <h2 style="color: #2d8f57;">Hello {{ $name }},</h2>

                <p>Your account has been successfully created. Here are your login credentials:</p>

                <ul style="padding-left: 20px;">
                    <li><strong>Username:</strong> {{ $username }}</li>
                    <li><strong>Password:</strong> {{ $password }}</li>
                </ul>

                <p>Please verify your email by clicking the button below:</p>

                <p style="text-align: center; margin: 30px 0;">
                    <a href="{{ $verificationUrl }}" style="background-color: #2d8f57; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 6px; display: inline-block;">
                        Verify Email
                    </a>
                </p>

                <p>If the button above doesn't work, copy and paste the following link into your browser:</p>
                <p style="word-break: break-all;">
                    <a href="{{ $verificationUrl }}" style="color: #2d8f57;">{{ $verificationUrl }}</a>
                </p>

                <p style="margin-top: 40px;">Best regards,</p>
                <p><strong>IKN Project Team</strong></p>
            </td>
        </tr>
    </table>

</body>

</html>