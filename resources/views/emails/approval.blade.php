<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $status === 'accepted' ? 'Welcome to Elunico Club!' : 'Your Elunico Club Membership Application' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">

    <div style="background-color: #fff; padding: 40px; border-radius: 10px; max-width: 600px; margin: auto; text-align: left;">
        
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('logo_black.png') }}" alt="Elunico Logo" style="max-width: 200px;">
        </div>

        <h1 style="color: #333;">Dear {{ $user->name }},</h1>

        @if($status === 'accepted')
            <p style="font-size: 16px; color: #333;">
                Thank you for your interest in joining Elunico Club.
            </p>
            <p style="font-size: 16px; color: green;">
                We are delighted to inform you that your application has been <strong>approved</strong>. We are excited to welcome you as a new member of our community, and we look forward to seeing you enjoy all the exclusive benefits and experiences we offer.
            </p>
            <p style="font-size: 16px;">
                You will soon receive additional details regarding your membership and instructions on how to access our members-only areas. If you have any questions or need assistance, please feel free to contact us at any time.
            </p>
            <p style="font-size: 16px;">
                Congratulations, and welcome to the Elunico family!
            </p>
        @else
            <p style="font-size: 16px; color: #333;">
                Thank you for your interest in Elunico Club and for taking the time to apply for membership.
            </p>
            <p style="font-size: 16px; color: red;">
                After careful consideration, we regret to inform you that your application was <strong>not successful</strong> at this time. We truly appreciate your interest, and we encourage you to reapply in the future should circumstances change.
            </p>
            <p style="font-size: 16px;">
                If you have any questions about the application process or would like further feedback, please don’t hesitate to contact us.
            </p>
            <p style="font-size: 16px;">
                We wish you all the best.
            </p>
        @endif

        <p style="margin-top: 40px; font-size: 14px; color: #999;">
            Best regards,<br>
            <strong>Elunico Group</strong>
        </p>
    </div>

</body>
</html>
