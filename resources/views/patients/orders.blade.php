<html>
    <body>
        <h1>Reporte 1</h1>

        <table>
            <thead>
            <tr>
                <th>Paciente</th>
                <th>Product</th>
                <th>Presentacion</th>
                <th>Precio</th>
                <th>Order</th>
            </tr>
            </thead>
            <tbody>

            @foreach($orders as $key => $order)
            {{ $personal_id = ""; }}
                @foreach ($order as $patient)
                    @if ($patient->patient->personal_id !== $personal_id)
                    
                    @else
                        <tr>
                            <td>{{ $patient->patient->first_name }} {{ $patient->patient->last_name }}</td>
                        </tr>
                    @endif
                    {{ $personal_id = $patient->patient->personal_id }}
                @endforeach


                @foreach ($order as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->product->presentation }}</td>
                        <td>{{ $detail->product->price }}</td>
                    </tr>
                @endforeach

            @endforeach
            </tbody>
            <tfoot>
                <th>
                    pie
                </th>
            </tfoot>
        </table>

    </body>
</html>
