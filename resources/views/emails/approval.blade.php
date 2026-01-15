<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $status === 'accepted' ? 'Welcome to El Unico!' : 'Your El Unico Membership Application' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">

<div style="background-color: #fff; padding: 40px; border-radius: 10px; max-width: 600px; margin: auto; text-align: left;">

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 30px;">
        <img src="{{ asset('logo_black.png') }}" alt="El Unico Logo" style="max-width: 200px;">
    </div>

    <h1 style="color: #333;">Dear {{ $user->name }},</h1>

@if($status === 'accepted')
    <!-- English Version -->
        <p style="font-size: 16px; color: #333;">
            Thank you for your interest in becoming an El Unico Member.
        </p>
        <p style="font-size: 16px; color: green;">
            We are delighted to inform you that your membership application has been <strong>approved</strong>. It is our pleasure to welcome you to the El Unico community and into one of the most exclusive cigar lounge experiences.
        </p>
        <p style="font-size: 16px;">
            At this stage, your membership is not yet active, and access to the El Unico Cigar Lounge will be granted only upon completion of the membership payment.
        </p>
        <p style="font-size: 16px;">
            To proceed, kindly follow the instructions provided within the app to finalize your payment. Once the payment has been confirmed, your membership will be activated, and your personal digital QR code for lounge access will automatically appear in the app.
        </p>
        <p style="font-size: 16px;">
            Kindly allow up to 24 hours for all other membership benefits and privileges to fully activate after payment processing.
        </p>
        <p style="font-size: 16px;">
            Should you have any questions or require assistance at any point, our team is always at your service.
        </p>
        <hr style="margin: 30px 0; border-color: #ddd;">
        <!-- Romanian Version -->
        <p style="font-size: 16px; color: #333;">
            Dragă {{ $user->name }},
        </p>
        <p style="font-size: 16px; color: green;">
            Vă mulțumim pentru interesul acordat în a deveni membru El Unico. Suntem încântați să vă informăm că cererea dumneavoastră de înscriere a fost <strong>aprobată</strong>. Este o plăcere pentru noi să vă urăm bun venit în comunitatea El Unico și într-una dintre cele mai exclusive experiențe de cigar lounge.
        </p>
        <p style="font-size: 16px;">
            În acest stadiu, calitatea de membru nu este încă activă, iar accesul în El Unico Cigar Lounge va fi permis doar după finalizarea plății aferente membership-ului.
        </p>
        <p style="font-size: 16px;">
            Pentru a continua, vă rugăm să urmați instrucțiunile din aplicație pentru a finaliza plata. După confirmarea plății, calitatea dumneavoastră de membru va fi activată, iar codul QR digital personal pentru acces în lounge va apărea automat în aplicație.
        </p>
        <p style="font-size: 16px;">
            Vă rugăm să permiteți până la 24 de ore pentru ca toate celelalte beneficii și privilegii ale membership-ului să se activeze complet după procesarea plății.
        </p>
        <p style="font-size: 16px;">
            Dacă aveți întrebări sau aveți nevoie de asistență în orice moment, echipa noastră este întotdeauna la dispoziția dumneavoastră.
        </p>
@else
    <!-- English Version -->
        <p style="font-size: 16px; color: #333;">
            Thank you for your interest in obtaining an El Unico Membership.
        </p>
        <p style="font-size: 16px; color: red;">
            We sincerely appreciate the time and consideration you devoted to your application. At this time, our El Unico Cigar Lounge has reached full membership capacity, and we are unable to extend additional memberships until new openings become available.
        </p>
        <p style="font-size: 16px;">
            We hold your interest in our distinguished community in the highest regard, and we would be pleased to revisit your application once capacity permits.
        </p>
        <p style="font-size: 16px;">
            Please note that while access to the private lounge is reserved exclusively for active members, our outdoor terrace remains open to the public, where you are warmly welcomed to enjoy the El Unico experience.
        </p>
        <p style="font-size: 16px;">
            Should you require further information or personal assistance, please feel free to contact us. Our team remains at your complete disposal.
        </p>
        <hr style="margin: 30px 0; border-color: #ddd;">
        <!-- Romanian Version -->
        <p style="font-size: 16px; color: #333;">
            Dragă {{ $user->name }},
        </p>
        <p style="font-size: 16px; color: red;">
            Apreciem cu sinceritate timpul și atenția pe care le-ați dedicat aplicației dumneavoastră. În acest moment, El Unico Cigar Lounge a atins capacitatea maximă de membri, iar noi nu putem acorda noi membership-uri până când nu vor deveni disponibile locuri suplimentare.
        </p>
        <p style="font-size: 16px;">
            Apreciem profund interesul dumneavoastră pentru comunitatea noastră de prestigiu și vom fi bucuroși să reevaluăm cererea dumneavoastră imediat ce vom avea disponibilitate.
        </p>
        <p style="font-size: 16px;">
            Vă rugăm să rețineți că, deși accesul la lounge-ul privat este rezervat exclusiv membrilor activi, terasa noastră exterioară rămâne deschisă publicului, unde sunteți întotdeauna binevenit să vă bucurați de experiența El Unico.
        </p>
        <p style="font-size: 16px;">
            Dacă aveți nevoie de informații suplimentare sau asistență personalizată, vă rugăm să ne contactați. Echipa noastră rămâne la dispoziția dumneavoastră.
        </p>
    @endif

    <p style="margin-top: 40px; font-size: 14px; color: #999;">
        Warm regards,<br>
        <strong>El Unico</strong>
    </p>
</div>

</body>
</html>
