<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Hi {{ $order->user->name }},</p>
    
    <p>Your order #{{ $order->id }} has been received and is being processed.</p>
    
    <h2>Order Details:</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price, 2) }}</td>
            <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
        </tr>
        @endforeach
    </table>
    
    <p><strong>Total Amount: {{ number_format($order->total_amount, 2) }}</strong></p>
    
    <h2>Shipping Information:</h2>
    <p>Address: {{ $order->shipping_address }}</p>
    <p>Phone: {{ $order->shipping_phone }}</p>
    
    <p>We will notify you once your order has been shipped.</p>
    
    <p>Best regards,<br>Your Store Team</p>
</body>
</html>