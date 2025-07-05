<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
    <p>Dear {{ $user->name }},</p>

    <p>Welcome to Seed Invoice App! We're thrilled to have you on board, and we hope you're ready to streamline your invoicing process with us.</p>
    <p>To ensure the security of your account and the integrity of your data, we kindly ask you to verify your newly created account. Verifying your account is a quick and easy step that adds an extra layer of protection.</p>
    <p>Please follow the link below to verify your account:</p>
    <p><a href="https://app.seedinvoice.com/verify?token={{ $user->verification_token }}">Verify Email</a></p>
    <p>We appreciate your prompt attention to this matter. If you have any questions or concerns, feel free to reach out to our support team at <a href="mailto:support@seedinvoiceapp.com">support@seedinvoiceapp.com</a>.</p>
    <p>Thank you for choosing Seed Invoice App!</p>

    <p>Best regards,<br>
    The Seed Invoice App Team</p>
</body>
</html>
