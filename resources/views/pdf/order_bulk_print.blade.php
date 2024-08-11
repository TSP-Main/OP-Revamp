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

        .order-container {
            page-break-before: always;
        }
    </style>
</head>

<body>
    @foreach($orders as $key => $order)
    <div class="{{ $loop->first ? '' : 'order-container'}}">
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
                                    <p style=" margin:0 !important; padding:0 !important; text-align:left; ">
                                        <strong>Store</strong></br>
                                        <small> <span style="font-weight: 500;">Pharmacy4u</span> </small></br>
                                        <small><span style="font-weight: 500;">Address: </span> Unit 2, Mansfield Station Gateway, Signal Way,</small></br>
                                        <small><span style="font-weight: 500;">City: </span> Nottingham ,</small></br>
                                        <small><span style="font-weight: 500;">Postal Code: </span> NG19 9QH, </small></br>
                                        <small><span style="font-weight: 500;">Phone: </span> 01623 572757 </small></br>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td style="border: none !important;">
                            <div class="col-6">
                                <div class="ship">
                                    <p style=" margin:0 !important; padding:0 !important; text-align:left; ">
                                        <strong>Ship to</strong></br>
                                        <small> <span style="font-weight: 500;">Customer Name: </span> {{$order['shipingdetails']['firstName'].' '.$order['shipingdetails']['lastName'] ?? ''}}</small></br>
                                        <small> <span style="font-weight: 500;">Home Name/No: </span> {{$order['shipingdetails']['address2'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">Address: </span> {{$order['shipingdetails']['address'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">City: </span> {{$order['shipingdetails']['city'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">Postal Code: </span> {{$order['shipingdetails']['zip_code'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">Phone: </span> {{$order['shipingdetails']['phone'] ?? ''}}</small></br>
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td style="border: none !important;">
                            <div class="col-6">
                                <div class="ship">
                                    <p style=" margin:0 !important; padding:0 !important; text-align:left; ">
                                        <strong>Bill to</strong></br>
                                        <small> <span style="font-weight: 500;">Customer Name: </span> {{$order['shipingdetails']['firstName'].' '.$order['shipingdetails']['lastName'] ?? ''}}</small></br>
                                        <small> <span style="font-weight: 500;">Home Name/No: </span> {{$order['shipingdetails']['address2'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">Address: </span> {{$order['shipingdetails']['address'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">City: </span> {{$order['shipingdetails']['city'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">Postal Code: </span> {{$order['shipingdetails']['zip_code'] ?? ''}}</small></br>
                                        <small><span style="font-weight: 500;">Phone: </span> {{$order['shipingdetails']['phone'] ?? ''}}</small></br>
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
                                    $src = (isset($val['variant']))? $val['variant']['image'] : $val['product']['main_image'];
                                    @endphp
                                    <td>
                                        <img style="height:55px; margin:0 !important; padding:0 !important;" src="{{ public_path('storage/'.$src) }}" alt="Product Image">
                                    </td>
                                    <td>
                                        <p style=" margin:0 !important; padding:0 !important; text-align:left; ">
                                            <small><strong>Product Name:</strong> {{$val['product_name'] ?? $val['product']['title']}}</small></br>
                                            <small><strong>Variant:</strong> {!! $val['variant_details'] ?? '' !!}</small></br>
                                            <small><strong>SKU:</strong> {{$val['variant']['sku'] ?? $val['product']['SKU']}}</small>
                                        </p>
                                    </td>
                                    <td>
                                        <p style=" margin:0 !important; padding:0 !important;">{{$val['product_qty']}}</p>
                                    </td>
                                    @if((isset($role) && $role == user_roles('1') || $role == user_roles('2')))
                                    <td>
                                        <p style=" margin:0 !important; padding:0 !important;">£{{number_format((float)str_replace(',', '', $val['product_price'] ?? $val['product']['price']), 2)}}</p>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                @if((isset($role) && $role == user_roles('1') || $role == user_roles('2')))
                                <tr>
                                    <td>
                                    <p style=" margin:0 !important; padding:0 !important; text-align:left; "> <strong>Shipping Charges:</strong></p>
                                    </td>
                                    <td>
                                    <p style=" margin:0 !important; padding:0 !important; text-align:left; ">£{{ number_format((float)str_replace(',', '', $order['shiping_cost']), 2) }}</p>
                                    </td>
                                    <td>
                                    <p style=" margin:0 !important; padding:0 !important; text-align:left; "> <strong>Total Amount:</strong></p>
                                    </td>
                                    <td>
                                        <p style=" margin:0 !important; padding:0 !important;">£{{ number_format((float)str_replace(',', '', $order['total_ammount']), 2) }}</p>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="thank-u">
                    <p>Dear Valued Customer, Thank you for choosing us for your pharmacy needs! <br>
                        <small><strong>Registered Office:</strong> 20-22 Wenlock Road, London N1 7GU.Company No: 13991146 VAT No: 440660907</small></br></br>
                        Download our FREE app directly from our website today! (https://nhs-prescriptions.uk/) <br>
                        Enjoy the ease of having your prescriptions delivered to your door, FREE and FAST.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</body>

</html>