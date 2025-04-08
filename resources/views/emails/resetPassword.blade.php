<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Password Reseted</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; color: #333;">

    <table style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <tr>
            <td>
                <h2 style="color: #2d8f57;">Hello {{ $name }},</h2>

                <p>Your password reseted!. Here are your login credentials:</p>

                <ul style="padding-left: 20px;">
                    <li><strong>Username:</strong> {{ $username }}</li>
                    <li><strong>Password:</strong> {{ $password }}</li>
                </ul>
                <p style="margin-top: 40px;">Best regards,</p>
                <p><strong>IKN Project Team</strong></p>
            </td>
        </tr>
    </table>

</body>

</html>