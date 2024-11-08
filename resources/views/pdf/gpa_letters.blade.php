<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Letter</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
            padding: 0 5px;
        }

        .main-cont {
            align-items: center;
            margin-bottom: 10px;
        }

        p {
            margin: 8px 0;
        }
    </style>
</head>

<body>
    <div class="container pdf-load">

        <div class="main-cont">
            <img src="{{ public_path('/img/pdf_logo.png') }}" height="230px" alt="logo">
            <h5>Dear Practice Manager,</h5>
            <p>I hope all is well.</p>
            <p>
                I recently had a private consultation with <b>Mr./Mis. {{ $order['user']['name'] ?? '' }}</b> ({{ $order['user']['dob'] ?? '' }} ) and I have deemed the
                following supply clinically appropriate for the management of their symptoms:
            </p>
            @foreach($order['orderdetails'] as $key => $item)
            @if($item['consultation_type'] == 'premd')
            <p style="color:blue; font-weight: 600;">
                {{++$key}}. {{$item['product']['title']}}
            </p>
            @endif
            @endforeach
            <p>
                This patient has consented for us to share this information with you as their regular GP and we are
                taking this opportunity to do so in the interest of transparency and providing the best possible
                ongoing care.
            </p>
            <p>
                I have attached the answers to the consultation questionnaire that the patient completed so that you
                can see the same information I was provided when determining the appropriateness of the supply. I
                also share the consultation notes for my prescribing decision. Please, therefore, update your own
                medical records accordingly.
            </p>
            <p>
                For any future supplies, if you know of any clinical reason(s) why this medication should not be
                issued or if you have any clinical amendments to suggest then please do let us know as soon as is
                practicable.
            </p>
            <br>
            <p>Kind Regards,</p>
            <p>Mr. Ali Awwad "Superintendent"</p>
            <p>GPhC: 2084469</p>
            <p>United Healthcare 4u</p>
            <p>Unit2, Signal Way</p>
            <p>Mansfield,</p>
            <p>NG19 9QH</p>

        </div>
</body>

</html>
