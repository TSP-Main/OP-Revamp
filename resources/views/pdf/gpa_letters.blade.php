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
            <p>I hope this letter finds you well</p>
            <p>
                I recently had a private consultation with <b>Mr./Mis. {{ $order['user']['name'] ?? '' }}</b>
                 (DOB: {{ $order['user']['profile']['date_of_birth'] ?? '' }}, 
                 Address: {{ implode(', ', array_filter([
                    $order['shipping_details']['address2'] ?? null,
                    $order['shipping_details']['address'] ?? null,
                    $order['shipping_details']['zip_code'] ?? null,
                    $order['shipping_details']['state'] ?? null,
                    $order['shipping_details']['city'] ?? null,
                ])) }}) and have deemed the following medication clinically appropriate for the management of their symptoms<br>
                {{-- Oder Date: {{ $order['created_at'] }} --}}
                
            </p><br>
            <div style="display: inline; flex-wrap: wrap;">
                <p style="margin-right: 10px;">Order Date: {{ \Illuminate\Support\Carbon::parse($order['created_at'])->format('Y-m-d') }}</p>
                @foreach($order['orderdetails'] as $key => $item)
                    @if($item['consultation_type'] == 'premd' || $item['consultation_type'] == 'premd/Reorder')
                        <p style="color:blue; font-weight: 600; margin-right: 10px;">
                            {{ ++$key }}. {{$item['product']['title']}}
                        </p>
                    @endif
                @endforeach
            </div>
            <br>
            <p>
                This patient has consented for us to share this information with you as their regular GP and we are
                taking this opportunity to do so in the interest of transparency and providing the best possible
                ongoing care.
            </p>
            <p>
                Please update your medical records accordingly. If there are any clinical reasons why this medication should not be issued or if you have any suggestions for clinical amendments, please let us know at your earliest convenience.
            </p>
            {{-- <p>
                For any future supplies, if you know of any clinical reason(s) why this medication should not be
                issued or if you have any clinical amendments to suggest then please do let us know as soon as is
                practicable.
            </p> --}}
            <br>
            <p>Kind Regards,</p>
            <p>Mr. Ali Awwad</p>
            <p>Superintendent Pharmacist</p>
            <p>GPhC: 2084469</p><br>
            <p>United Healthcare 4u</p>
            <p>Unit2, Signal Way</p>
            <p>Mansfield,</p>
            <p>NG19 9QH</p>

        </div>
</body>

</html>
