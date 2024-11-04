<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Prints</title>
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
            padding: 0 15px;
        }

        .main-cont {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .pdf-load ul, .pdf-load li {
            list-style: none;
            padding-left: 0;
        }

        .ship, .item {
            margin-bottom: 20px;
        }

        .text-end {
            text-align: end;
        }

        .thank-u {
            margin-top: 20px;
            text-align: center;
        }

        .thank-u p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1px !important;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        #tbl_header, #tbl_shiping {
            border: none;
            width: 100%;
        }

        #tbl_header td:first-child {
            text-align: left;
        }

        #tbl_header td:last-child {
            text-align: right;
        }

        #tbl_shiping td, #tbl_pro_details td {
            padding: 10px;
        }

        .order-container {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @foreach($orders as $order)
    <div class="{{ $loop->first ? '' : 'order-container'}}">
        <div class="container pdf-load">
            <div class="main-cont">
                <table id="tbl_header">
                    <tr>
                        <td>
                            <h2>Online Pharmacy 4U</h2>
                        </td>
                        <td>
                            <ul>
                                <li>#{{ $order['id'] ?? '' }}</li>
                                <li>{{ \Carbon\Carbon::parse($order['created_at'] ?? '')->format('M, d, Y - H:i') }}</li>
                            </ul>
                        </td>
                    </tr>
                </table>
                <table id="tbl_shiping">
                    <tr>
                        <!-- Store Information -->
                        <td>
                            <strong>Store</strong><br>
                            <small>Pharmacy4u</small><br>
                            <small>Address: Unit 2, Mansfield Station Gateway, Signal Way,</small><br>
                            <small>City: Nottingham, Postal Code: NG19 9QH, Phone: 01623 572757</small>
                        </td>
                        <!-- Shipping Information -->
                        <td>
                            <strong>Ship to</strong><br>
                            <small>Customer Name: {{ $order['shipping_details']['firstName'] ?? '' }} {{ $order['shipping_details']['lastName'] ?? '' }}</small><br>
                            <small>Home Name/No: {{ $order['shipping_details']['address2'] ?? '' }}</small><br>
                            <small>Address: {{ $order['shipping_details']['address'] ?? '' }}, {{ $order['shipping_details']['city'] ?? '' }}</small><br>
                            <small>Postal Code: {{ $order['shipping_details']['zip_code'] ?? '' }}, Phone: {{ $order['shipping_details']['phone'] ?? '' }}</small>
                        </td>
                        <!-- Billing Information -->
                        <td>
                            <strong>Bill to</strong><br>
                            <small>Customer Name: {{ $order['shipping_details']['firstName'] ?? '' }} {{ $order['shipping_details']['lastName'] ?? '' }}</small><br>
                            <small>Home Name No: {{ $order['shipping_details']['address2'] ?? '' }}</small><br>
                            <small>Address: {{ $order['shipping_details']['address'] ?? '' }}, {{ $order['shipping_details']['city'] ?? '' }}</small><br>
                            <small>Postal Code: {{ $order['shipping_details']['zip_code'] ?? '' }}, Phone: {{ $order['shipping_details']['phone'] ?? '' }}</small>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Order Details Table -->
            <div class="item">
                <table id="tbl_pro_details">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order['orderdetails'] ?? [] as $val)
                        <tr>
                            <td>
                                <img src="{{ public_path('storage/'.$val['product']['main_image'] ?? '') }}" alt="Product Image">
                            </td>
                            <td>
                                <strong>Product Name:</strong> {{ $val['product']['title'] ?? 'N/A' }}<br>
                                <small><strong>Variant:</strong> {!! $val['variant']['title']?? '' !!}</small><br>
                                <small><strong></strong> {!! $val['variant']['value']?? '' !!}</small><br>
                                <strong>SKU:</strong> {{ $val['product']['SKU'] ?? '' }}
                            </td>
                            <td>{{ $val['product_qty'] }}</td>
                            <td>£{{ number_format((float)str_replace(',', '', $val['variant']['price'] ?? $val['product']['price']['product_price'] ?? $val['product']['price']), 2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2"><strong>Shipping Charges:</strong></td>
                            <td colspan="2">£{{ number_format((float)$order['shipping_details']['cost'] ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Total Amount:</strong></td>
                            <td colspan="2">£{{ number_format((float)$order['total_ammount'] ?? 0, 2) }}</td>
                        </tr>
                    
                    </tbody>
                </table>
            </div>

            <!-- Thank You Note -->
            <div class="thank-u">
                <p>
                    Dear Valued Customer, Thank you for choosing us for your pharmacy needs! <br>
                    <small><strong>Registered Office:</strong> 20-22 Wenlock Road, London N1 7GU. Company No: 13991146 VAT No: 440660907</small><br>
                    Download our FREE app directly from our website today! (https://nhs-prescriptions.uk/)<br>
                    Enjoy the ease of having your prescriptions delivered to your door, FREE and FAST.
                </p>
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>
