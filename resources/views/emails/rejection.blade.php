<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update from Online Pharmacy 4U</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            margin: 40px auto;
            max-width: 800px;
            background-color: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            border-radius: 10px;
            text-align: center;
        }

        h1 {
            color: #2D90D5;
            font-size: 24px;
        }

        h3 {
            color: #2D90D5;
            font-size: 20px;
        }

        p {
            margin: 10px 0;
            line-height: 1.6;
            font-size: 16px;
        }

        .button-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 40px 0;
            gap: 20px;
        }

        .button {
            padding: 14px 28px;
            background-color: #2D90D5;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background-color: #1a6fa8;
        }

        footer {
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }

        @media (max-width: 500px) {
            .container {
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Online Pharmacy 4U</h1>
         <p>Your order with ID <strong> {{ $order->id }} </strong> has been rejected.</p>
    <p><strong>Health Care Professional Remarks:</strong> {{ $hcpRemarks }}</p>
        <p>Regrettably, your order cannot be completed based on our consultation review.</p>

        <p>We apologize, but unfortunately, we are unable to prescribe you this item at this time as it would be deemed unsafe based on your consultation & summary care records. We advise you to speak with your GP for a diagnosis. If you have had this prescribed previously from your GP and have proof, we may be able to process your order, so please advise us as soon as possible.</p>

        <p>We have refunded you in the meantime in line with our <a href="https://online-pharmacy4u.co.uk/pages/return">Refunds, Returns & Prescriptions Rejections policy</a>. We hope to see you again, and sorry for any inconvenience caused. Please accept this discount code: <strong>5OUT</strong> for 5% off your next order.</p>

        <p>Please note that funds can take 24-48 hours to clear into your bank.</p>

        <div class="button-container">
            <a href="{{ url('/') }}" class="button">Visit Our Store</a>
        </div>

        <p>Thank you for your interest in our products!</p>
        <footer>
            <p>If you have any questions, feel free to <a href="mailto:info@online-pharmacy4u.co.uk">contact us</a>.</p>
        </footer>
    </div>
</body>

</html>
