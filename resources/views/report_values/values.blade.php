<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th colspan="4">Cargue de valores</th>
                </tr>
                <tr>
                    <th>Paciente</th>
                    <th>Cédula</th>
                    <th>Código Autorización</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $key=>$patient)
                    <tr>
                        <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                        <td>{{ $patient->personal_id }}</td>
                        <td>{{ $patient->lm_code }}</td>
                        <td data-format="#.##0_-">{{ $patient->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
