<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>We hope this message finds you well. You are receiving this email because a password reset was requested for your account at <b>Seed Invoice App</b>.</p>
    <p>
        Click the following link to reset your password:
        <p><a href="https://app.seedinvoice.com/reset-password?token={{ $resetToken }}&email={{ $user->email }}">Reset Password</a></p>
    </p>
    <p>
        If you did not request a password reset, no further action is required.
    </p>
    <p>Thank you!</p>
    <hr>
    <p>
        Best regards,<br>
        The Seed Invoice App Team
    </p>
</body>
</html>
