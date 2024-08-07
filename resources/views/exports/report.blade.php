<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Total Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data )
                <tr>
                    <td>{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</td>
                    <td>{{ $data->customer_count }}</td>
                    <td>{{ $data->total_payment }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Grand Total</th>
                <th></th>
                <th>{{ $total }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
