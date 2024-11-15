<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
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

        .pdf-load li {
            list-style: none;
        }

        .pdf-load ul {
            padding-left: 0;
        }

        .ship,
        .item {
            margin-bottom: 20px;
        }

        .item h4 {
            margin: 0;
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

        th,
        td {
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

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        #tbl_header,
        #tbl_shiping {
            border: none;
            width: 100%;
        }

        #tbl_header td:first-child {
            text-align: left;
        }

        #tbl_header td:last-child {
            text-align: right;
        }

        #tbl_shiping td {
            text-align: left;
            padding: 10px 10px;
        }

        #tbl_pro_details td {
            text-align: center;
            padding: 10px 10px;
        }
    </style>
</head>

<body>
    <div class="container pdf-load">

        <div class="main-cont">
            <table id="tbl_header" style="border: none !important;">
                <tr style="border: none !important;">
                    <td style="border: none !important;">
                        <h2>Online Pharmacy 4U</h2>
                    </td>
                    <td style="border: none !important;">
                        <ul>
                            <li>#{{$order['id'] ?? ''}}</li>
                            <li>{{ \Carbon\Carbon::parse($order['created_at'] ?? '')->format('M, d, Y - H:i') }}</li>
                        </ul>
                    </td>
                </tr>
            </table>
            <table id="tbl_shiping">
                <tr>
                    <td style="border: none !important;">
                        <div class="col-6">
                            <div class="ship">
                                <p style="margin: 0 !important; padding: 0 !important; text-align: left;">
                                    <strong>Store</strong><br>
                                    <small>Pharmacy4u</small><br>
                                    <small><strong>Address:</strong> Unit 2, Mansfield Station Gateway, Signal Way,</small><br>
                                    <small><strong>City:</strong> Nottingham</small><br>
                                    <small><strong>Postal Code:</strong> NG19 9QH</small><br>
                                    <small><strong>Phone:</strong> 01623 572757</small>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="border: none !important;">
                        <div class="col-6">
                            <div class="ship">
                                <p style="margin: 0 !important; padding: 0 !important; text-align: left;">
                                    <strong>Ship to</strong><br>
                                    <small><strong>Customer Name:</strong> {{$order['shipping_details']['firstName'].' '.$order['shipping_details']['lastName'] ?? ''}}</small><br>
                                    <small><strong>Home Name/No:</strong> {{$order['shipping_details']['address2'] ?? ''}}</small><br>
                                    <small><strong>Address:</strong> {{$order['shipping_details']['address'] ?? ''}}</small><br>
                                    <small><strong>City:</strong> {{$order['shipping_details']['city'] ?? ''}}</small><br>
                                    <small><strong>Postal Code:</strong> {{$order['shipping_details']['zip_code'] ?? ''}}</small><br>
                                    <small><strong>Phone:</strong> {{$order['shipping_details']['phone'] ?? ''}}</small>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="border: none !important;">
                        <div class="col-6">
                            <div class="ship">
                                <p style="margin: 0 !important; padding: 0 !important; text-align: left;">
                                    <strong>Bill to</strong><br>
                                    <small><strong>Customer Name:</strong> {{$order['shipping_details']['firstName'].' '.$order['shipping_details']['lastName'] ?? ''}}</small><br>
                                    <small><strong>Home Name/No:</strong> {{$order['shipping_details']['address2'] ?? ''}}</small><br>
                                    <small><strong>Address:</strong> {{$order['shipping_details']['address'] ?? ''}}</small><br>
                                    <small><strong>City:</strong> {{$order['shipping_details']['city'] ?? ''}}</small><br>
                                    <small><strong>Postal Code:</strong> {{$order['shipping_details']['zip_code'] ?? ''}}</small><br>
                                    <small><strong>Phone:</strong> {{$order['shipping_details']['phone'] ?? ''}}</small>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="row">
            <div class="col-12">
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
                            @foreach($order['orderdetails'] ?? [] as $key => $val)
                            <tr>
                                @php
                                $src = (isset($val['variant'])) ? $val['variant']['image'] : $val['product']['main_image'];
                                @endphp
                                <td>
                                    <img style="height:55px; margin:0 !important; padding:0 !important;" src="{{ public_path('storage/'.$src) }}" alt="Product Image">
                                </td>
                                <td>
                                    <p style="margin: 0 !important; padding: 0 !important; text-align: left;">
                                        <small><strong>Product Name:</strong> {{$val['product_name'] ?? $val['product']['title']}}</small><br>
                                        <small><strong>Variant:</strong> {!! $val['variant_details'] ?? '' !!}</small><br>
                                        <small><strong>SKU:</strong> {{$val['variant']['sku'] ?? $val['product']['SKU']}}</small>
                                    </p>
                                </td>
                                <td>{{$val['product_qty']}}</td>
                                <td>£{{ number_format((float)str_replace(',', '', $val['variant']['price'] ?? $val['product']['price']['product_price'] ?? $val['product']['price']), 2) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2"><strong>Shipping Charges:</strong></td>
                                <td colspan="2">£{{ number_format((float)str_replace(',', '', $order['shipping_cost']), 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Total Amount:</strong></td>
                                <td colspan="2">£{{ number_format($order['total_ammount'], 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="thank-u">
                <p>Dear Valued Customer, Thank you for choosing us for your pharmacy needs! <br>
                    <small><strong>Registered Office:</strong> 20-22 Wenlock Road, London N1 7GU. Company No: 13991146 VAT No: 440660907</small><br><br>
                    Download our FREE app directly from our website today! (https://nhs-prescriptions.uk/) <br>
                    Enjoy the ease of having your prescriptions delivered to your door, FREE and FAST.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
