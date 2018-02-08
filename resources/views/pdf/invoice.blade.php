<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        p {
          color: #888;
        }

        table {
            padding: 0px 10px 0px 5px;
            width: 100%;
            color: white;
            font-family: sans-serif;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            font-size: 60px;
        }

        .menu {
            background-color: whitesmoke;
            padding-left: 10%;
            padding-right: 10%;
            text-align: left;
        }

        .info {
            background-color: whitesmoke;
            color: #222729;
            padding-left: 10%;
            padding-right: 10%;
        }

        .Content {
            background-color: white;
            color: #666;
            padding-left: 10%;
            padding-right: 10%;
        }

        .FirstContent {
            background-color: #ecf1f1;
            color: #666;
        }

        .EndContent {
            background-color: #ecf1f1;
            color: #666;
        }

        .footer {
            background-color: whitesmoke;
            color: #888;
            text-decoration: none;
            border: 0px;
            text-align: center;
            padding-left: 35%;
            padding-right: 35%;
        }

        .quittance {
            color: #222729;
            text-align: left;
        }

        .align-left {
            text-align: left;
            width: 25%;
            padding: 15px;
            vertical-align: top;
        }

        .align-right {
            text-align: right;
            width: 25%;
            padding: 15px;
            vertical-align: top;
        }

        .align-center {
          text-align: center;
          width: 25%;
          padding: 15px;
          vertical-align: top;
        }
    </style>
</head>

<body>
    <table class="menu">
        <tr>
            <td class="quittance">
                <h1>QUITTANCE</h1>
            </td>
            <td>
                <img style="float: right;" src="http://www.paintballarea.ch/images/logo_0.png" alt="Logo Paintball Area">
            </td>
        </tr>
    </table>
    <table class="info">
        <tr>
            <th class="align-left">
                <h4>FACTURÉ À:</h4>

                <h4>{{ $locationObject->client['name'] }} {{ $locationObject->client['last_name'] }}</h4>
                <h4>{{ $locationObject->client['email'] }}</h4>
                <h4>{{ $locationObject->client['phone'] }}</h4>

            </th>
            <th class="align-center">
                <h4>TERRAIN:</h4>

                <h4>A</h4>
            </th>
            <th class="align-right">
                <h4>DURÉE</h4>

                <h4>{{ $locationObject->hour_start }}</h4>
                <h4>à</h4>
                <h4>{{ $locationObject->hour_end }}</h4>

            </th>
            <th class="align-right">
                <h4>DATE:</h4>

                <h4>{{ $locationObject->day }}</h4>

            </th>
        </tr>
    </table>
    <table class="Content">

        <tr>
            <th class="align-left">QTÉ</th>
            <th class="align-center">DÉSIGNATION</th>
            <th class="align-right">PRIX UNITÉ</th>
            <th class="align-right">MONTANT</th>
        </tr>

        @foreach ($payments as $payment)
          <tr>
              <td class="align-left">{{ $payment->quantity }}</td>
              <td class="align-center">{{ $payment->product->name }}</td>
              <td class="align-right">{{ $payment->product->price }}.- </td>
              <td class="align-right">{{ $payment->product->price * $payment->quantity }} .- </td>
          </tr>
        @endforeach

    </table>
    <table class="Content">
        <tr>
            <td style="text-align: center; width: 50%; padding: 15px;"></td>
            <td class="align-right">
                <h2>Total</h2>
            </td>
            <td class="align-right"><h2> 4000  .-</h2></td>
        </tr>
    </table>

    <table class="footer">
        <tr>
            <td>
                <p>Rue du Borget 7
                    <br>
                    <br> 1377 Oulens-sous-Echallen</p>
            </td>
            <td>
                <p>inscription@paintballarea.ch
                    <br>
                    <br>
                        077 415 30 02
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
