<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmations</title>
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
            max-width: 1100px;
            background-color: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            border-radius: 10px;
        }

        .main-content {
            max-width: 800px;
            margin: auto;
        }

        .order {
            float: right;
            font-weight: bold;
            color: #666;
        }

        .button-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 40px 0;
        }

        table {
            font-family: 'Roboto', sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: none;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
            padding: 12px 15px;
        }

        td ul {
            padding-left: 0;
        }

        td ul li {
            list-style: none;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button-container .button {
            padding: 14px 28px;
            background-color: #2D90D5;
            color: #ffffff;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
            display: inline-block;
            margin: 0 10px;
        }

        .button-container .button:hover {
            background-color: #1a5f8a;
            transform: translateY(-2px);
        }

        .button-container span {
            margin: 0 20px;
            color: #666;
        }

        .button-container a {
            color: #2D90D5;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .button-container a:hover {
            color: #1a2232;
        }

        .your-order {
            margin-top: 60px;
            text-align: center;
        }

        .your-order h2 {
            color: #2D90D5;
        }

        .your-order p {
            color: #555;
        }

        @media (max-width: 500px) {
            .container {
                width: 100%;
                padding: 10px;
            }

            .order {
                float: none;
                text-align: center;
                display: block;
                margin: 10px 0;
            }

            .button-container {
                flex-direction: column;
                align-items: center;
            }

            .button-container .button {
                font-size: 16px;
                padding: 10px;
                margin-bottom: 10px;
            }

            .button-container span {
                display: none;
            }

            .button-container a {
                font-size: 16px;
            }

            table {
                font-size: 14px;
            }

            td ul li {
                font-size: 14px;
            }

            .your-order h2,
            .your-order p {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-content">
        <h2>Dear {{ $order->shipingdetails->firstName ?? ''}}</h2>
        <p class="order">Order #{{$order->id ?? '' }}</p>

            <div class="your-order">
                <h2>Your order has been successfully placed!</h2>
                <p>Great news, your order is currently being reviewed by our dispensary & prescribing team. We’ll send you tracking notifications once it’s been approved, dispensed & shipped!</p>
                <div class="button-container">
                    <a href="{{url('/admin')}}" class="button">Visit your order</a>
                    <span style="font-size: 20px; padding-top: 13px;">or</span>
                    <a style="padding-top: 15px;" href="{{url('/')}}">Visit our store</a>
                </div>
            </div>

            <h2 style="margin-top: 40px;">Items in this shipment</h2>
            <table>
                @foreach($order->orderdetails ?? [] as $key => $val)
                <tr>
                    @php
                    $src = isset($val->variant) ? $val->variant->image : $val->product->main_image;
                    @endphp
                    <td>
                        <img style="height:55px; margin:0 !important; padding:0 !important;" src="{{ public_path('storage/'.$src) }} " alt="Product Image">
                    </td>
                    <td>
                        <ul>
                            <li>{{ $val->product_name ?? $val->product->title }} x {{ $val->product_qty }}</li>
                            <li>{!! $val->variant_details ?? '' !!}</li>
                            <li>{{ $val->variant->barcode ?? $val->product->barcode }}</li>
                        </ul>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
