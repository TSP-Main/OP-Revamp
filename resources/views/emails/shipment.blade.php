<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Has Been Shipped!</title>
</head>
<body>
    <h1>Your Order Has Been Shipped!</h1>

    <p>Dear {{ $order['user']['name'] }},</p>

    <p>Your order has been successfully shipped! Below are the details:</p>

    <ul>
        <li><strong>Order Identifier:</strong> {{ $order_identifier }}</li>
        <li><strong>Tracking Number:</strong> {{ $tracking_no }}</li>
    </ul>

    <p>You can track your order using the tracking number provided above.</p>

    <p>If you have any questions or concerns, feel free to reach out to our support team.</p>

    <p>Thank you for shopping with us!</p>

    <p>Best Regards,<br>
    The [Your Store Name] Team</p>
</body>
</html>
