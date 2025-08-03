<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Status</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">

    <div style="background-color: #fff; padding: 40px; border-radius: 10px; max-width: 600px; margin: auto; text-align: center;">
        <h1 style="color: #333;">Hello {{ $user->name }},</h1>

        @if($status === 'accepted')
            <p style="font-size: 18px; color: green;">
                🎉 Congratulations! Your application has been accepted.
            </p>
        @else
            <p style="font-size: 18px; color: red;">
                😞 We’re sorry, your application has been rejected.
            </p>
        @endif

        <p style="margin-top: 40px; font-size: 14px; color: #999;">
            Best regards,<br>
            The <strong>AppName</strong> Team
        </p>
    </div>

</body>
</html>
