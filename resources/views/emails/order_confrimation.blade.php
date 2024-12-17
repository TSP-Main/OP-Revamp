<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fc;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 40px 30px;
            overflow: hidden;
        }

        .header {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 2px solid #e6e9f2;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 32px;
            color: #1a73e8;
            font-weight: 700;
            margin: 0;
        }

        .order-info {
            float: right;
            font-weight: bold;
            color: #1a73e8;
            font-size: 18px;
        }

        .order-status {
            text-align: center;
            margin-top: 40px;
        }

        .order-status h2 {
            font-size: 26px;
            color: #1a73e8;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .order-status p {
            font-size: 18px;
            color: #555;
            margin: 20px 0;
        }

        .button-container {
            display: inline-block;
            justify-content: center;
            margin-top: 25px;
        }

        .button-container a {
            background: linear-gradient(135deg, #1a73e8, #4285f4);
            color: white;
            padding: 15px 30px;
            border-radius: 40px;
            font-size: 18px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
            transition: all 0.3s ease;
        }

        .button-container a:hover {
            background: linear-gradient(135deg, #4285f4, #1a73e8);
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
        }

        table {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
            font-size: 16px;
        }

        table th,
        table td {
            padding: 16px;
            text-align: left;
            font-size: 16px;
        }

        table th {
            background-color: #f9f9f9;
            color: #1a73e8;
            font-weight: 600;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f6f9fc;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .item-details ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .item-details ul li {
            font-size: 15px;
            color: #555;
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 16px;
            color: #888;
        }

        .footer .email {
            color: #1a73e8;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .order-info {
                float: none;
                text-align: center;
                margin-top: 20px;
            }

            .button-container {
                display: flex;
                flex-direction: column;
                gap: 15px;
                align-items: center;
                margin-top: 25px;
            }

            .button-container a {
                width: 100%;
                text-align: center;
                padding: 15px;
            }

            .item-image {
                width: 70px;
                height: 70px;
            }

            table th, table td {
                font-size: 14px;
                padding: 12px;
            }

            .footer {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
            <div class="order-info">
                Order #{{$order->id ?? ''}}
            </div>
        </div>

        <div class="order-status">
            <h2>Thank you for your order, {{ $order->shipingdetails->firstName ?? ''}}!</h2>
            <p>Your order is currently being processed by our team. We’ll notify you once it’s shipped and ready for tracking!</p>

            <div class="button-container">
                <a href="{{url('/dashboard')}}">View Your Order</a>
                <a href="{{url('/')}}">Return to Store</a>
            </div>
        </div>

        <h2 style="margin-top: 50px; text-align: center;">Items in Your Order</h2>

        <table>
            @foreach($order->orderdetails ?? [] as $key => $val)
            <tr>
                <td><img class="item-image" src="{{ public_path('storage/'.$val->product->main_image ?? $val->variant->image) }}" alt="Product Image"></td>
                <td class="item-details">
                    <ul>
                        <li><strong>{{ $val->product_name ?? $val->product->title }}</strong> x {{ $val->product_qty }}</li>
                        <li>{!! $val->variant_details ?? '' !!}</li>
                        <li>{{ $val->variant->barcode ?? $val->product->barcode }}</li>
                    </ul>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="footer">
            <p>If you have any questions, feel free to reach out to us at <span class="email">info@online-pharmacy4u.co.uk</span>.</p>
        </div>
    </div>
</body>

</html>
