<!DOCTYPE html>
<html>

<head>
    <title>Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .summary {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Sales Report</h1>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Customer</th>
                <th>Products</th>
                <th>Total Items</th>
                <th>Total Sales</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $order->user->name }}</td>
                <td>
                    @foreach($order->items as $item)
                    {{ $item->product->name }} (Qty: {{ $item->quantity }})<br>
                    @endforeach
                </td>
                <td>{{ $order->items->sum('quantity') }}</td>
                <td>Rp {{ number_format($order->total_amount, 2) }}</td>
                <td>{{ $order->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p>Total Sales: Rp {{ number_format($total_sales, 2) }}</p>
        <p>Total Items Sold: {{ $total_items }}</p>
    </div>
</body>

</html>