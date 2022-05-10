<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            }
        </style>
    </head>
<body>
    <h1></h1>

    <table style="width:100%">
        <thead>
            <tr>
                <th colspan="7">Relacion de pacientes Seguros Bolivar S.A</th>
            </tr>
            <tr>
                <th colspan="7">Asispharma SAS . NIT 900.644.246-3</th>
            </tr>
            <tr>
                <th colspan="7">Factura #</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key => $order)
                @php($patientPerOrder = [])
                @foreach ($order as $patient)
                    @if (!in_array($patient->patient->patient_id, $patientPerOrder))
                        <tr>
                            <td rowspan="{{ count($order) }}">{{ $patient->patient->first_name }} {{ $patient->patient->last_name }}</td>
                            <td rowspan="{{ count($order) }}">{{ $patient->patient->personal_id }} </td>
                            <td rowspan="{{ count($order) }}">{{ $patient->order->lm_code }} <br>{{ $patient->order->authorized_by }}</td>
                    @else
                        <tr>
                    @endif
                        <td>{{ $patient->product->name }}</td>
                        <td>{{ $patient->prescription }}</td>
                        <td>{{ $patient->product->presentation }}</td>
                        <td>{{ $patient->product->price }}</td>
                    </tr>
                    {{ $patientPerOrder[] = $patient->patient->patient_id }}
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>Valor total formula: {{ array_reduce(
                        $order->toArray(),
                        function ($sum, $patient) {
                            return (float) ($sum += (float) $patient['product']['price']);
                        },
                        0,
                    ) }}</strong>
                    </td>
                    <td></td>
                </tr>
                <tr><td></td></tr>
            @endforeach
        </tbody>
        <tfoot>
            <th>
                pie
            </th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                {{ $orders->map(function($order) {
                    return array_reduce(
                        $order->toArray(),
                        function ($sum, $patient) {
                            return (float) ($sum += (float) $patient['product']['price']);
                        },
                        0,
                    );
                })->reduce(function($a, $b){
                    return $a+$b;
                }) }}
            </td>

        </tfoot>
    </table>

</body>

</html>
