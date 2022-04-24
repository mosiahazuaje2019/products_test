<html>
    <body>
        <h1>Reporte 1</h1>

        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th>Precio</th>
                <th>Order</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->product->price }}</td>
                    <td>{{ $order->order_id }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </body>
</html>
