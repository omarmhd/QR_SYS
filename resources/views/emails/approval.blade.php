<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Approved</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; margin: 0;">

    <div style="max-width: 600px; background-color: #ffffff; margin: 0 auto; padding: 40px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;">

        <h1 style="color: #333; font-size: 28px; margin-bottom: 20px;">
            Welcome, {{ $user->name }}!
        </h1>

        <p style="font-size: 18px; color: #555; margin-bottom: 30px;">
            🎉 Congratulations! Your subscription has been <strong style="color: green;">approved</strong>.
        </p>

        <p style="font-size: 16px; color: #777; margin-bottom: 40px;">
            We're excited to have you with us. You now have full access to all premium features and updates.
        </p>

        <hr style="margin: 40px 0; border: none; border-top: 1px solid #ddd;">

        <!-- App badges only -->
        <div style="margin-top: 10px;">
            <a href="https://play.google.com/store/apps/details?id=your.app.id" style="margin: 0 10px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" height="40">
            </a>
            <a href="https://apps.apple.com/app/id123456789" style="margin: 0 10px;">
                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on the App Store" height="40">
            </a>
        </div>

        <p style="font-size: 14px; color: #999; margin-top: 50px;">
            Best regards,<br>
            The <strong>AppName</strong> Team
        </p>

    </div>

</body>
</html>
