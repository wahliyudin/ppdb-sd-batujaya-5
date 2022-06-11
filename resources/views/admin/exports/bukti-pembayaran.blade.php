<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran | {{ $item_payment->payment_number }}</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        table.data {
            border-collapse: collapse;
            width: 100%;
        }

        table.data th,
        table.data td {
            padding: 10px;
        }

        table.data th {
            background-color: #1aa121;
            color: white;
        }
    </style>
</head>

<body style="padding: 30px 20px;">
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td>
                    <span style="font-size: 25px;">SDN BATUJAYA 5</span>
                </td>
                <td style="text-align: right;">
                    <span style="font-size: 20px;">Bukti Pembayaran</span>
                </td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table style="margin: 10px 0;">
        <tbody>
            <tr>
                <td>Nama</td>
                <td style="padding: 0 10px;">:</td>
                <td>{{ $item_payment->payment->user->student->nama }}</td>
            </tr>
            <tr>
                <td>NIS</td>
                <td style="padding: 0 10px;">:</td>
                <td>{{ $item_payment->payment->user->student->nis }}</td>
            </tr>
        </tbody>
    </table>
    <table class="data">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Pembayaran</th>
                <th>Keterangan</th>
                <th>Jumlah Bayar</th>
                <th>Jumlah Kembalian</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $item_payment->tanggal }}</td>
                <td>{{ $item_payment->no_pembayaran }}</td>
                <td>{{ $item_payment->keterangan }}</td>
                <td>{{ numberFormat($item_payment->nominal, 'Rp.') }}</td>
                <td>{{ numberFormat($item_payment->kembalian, 'Rp.') }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
