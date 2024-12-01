<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Entregas</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #334155;
            margin: 0px;
            height: 100vh;
            box-sizing: border-box;
        }

        h1, h2, h3 {
            margin: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1e293b;
            padding: 10px 20px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-weight: bold;
            font-style: italic;
            font-size: 24px;
        }


        .clearfix::after {
            content: '';
            display: block;
            clear: both;
        }

        .card {
            padding: 20px;
            border: 1px solid #1e293b;
            border-radius: 8px;
            margin-bottom: 20px;
            position: relative;
        }

        .column {
            float: left;
            width: 48%;
            margin-right: 4%;
            box-sizing: border-box;
        }

        .column:last-child {
            margin-right: 0;
        }

        .card h2 {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 0 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .card div {
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #1e293b;
        }

        .table th {
            background-color: #1e293b;
            color: #fff;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            height: 100px;
        }

        .footer div {
            width: 40%;
            text-align: center;
        }

        .footer div img {
            max-width: 100px;
            width: 100%;
            margin-bottom: 10px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer div p {
            
            border-top: 1px solid #000;
            padding-top: 10px;
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Entregas</h1>
        <img src="{{ public_path('images/logoagenda.jpg') }}" alt="Logo">
    </div>

    <div class="card clearfix">
        <h2>Proveedor</h2>
        <div class="column">
            <div>
                <strong>{{ $to->name }}</strong><br>
                {{ $to->business_name }} ({{ $to->business_activity }})
            </div>
            <div>
                <strong>RFC:</strong> {{ $to->tax_id }}
            </div>
            <div>
                <strong>Correo:</strong> {{ $to->email }}
            </div>
            <div>
                <strong>Teléfono:</strong> {{ $to->phone_number }}
            </div>
        </div>
        
        <div class="column">
            <strong>Dirección:</strong><br>
            Calle: {{ $to->street }}, Ext: #{{ $to->ext_number }}, Int: #{{ $to->int_number }}<br>
            Colonia: {{ $to->neighborhood }}<br>
            Municipio: {{ $to->town }}, Estado: {{ $to->state }}<br>
            CP: {{ $to->postal_code }}
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Residuo</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deliveries as $delivery)
                <tr>
                    <td>{{ $delivery->waste->category }}</td>
                    <td>{{ $delivery->quantity }} {{ $delivery->waste->unit }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <td>{{ $total }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <div>

            <p>{{ $to->name }}</p>
        </div>
        <div>
            @isset(auth()->user()->CMUser->signature_url)
                <img src="{{ public_path('storage/' . auth()->user()->CMUser->signature_url) }}" alt="Signature">
            @endisset

            <p>{{ $from->name }}</p>
        </div>
    </div>

</body>
</html>
