<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .invoice {
            width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .invoice-header p {
            line-height: 1.5;
            margin: 0;
        }

        .invoice-desc {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .invoice-desc p {
            margin: 0;
        }

        .invoice-body {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
        }

        .left {
            width: 30%;
            padding-right: 20px;
        }

        .right {
            width: 70%;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="invoice-header">
            <h1>Invoice</h1>
            <p>Cafe Pena Tinta Bandung</p>
            <p>Jl. Raya Bandung – Garut ByPass No.47, Citaman, Kec. Nagreg Kab. Bandung.</p>
        </div>
        <div class="invoice-desc">
            <div class="left">
                <p>No. Pesanan: {{ $order->no_order }}</p>
                <p>Customer: {{ $order->name }}</p>
                <p>Tanggal: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
            </div>
            <div class="right">
                <p>Status Pesanan : {{ $order->status }}</p>
                <p>Status Pembayaran : {{ $order->payment_status }}</p>
            </div>
        </div>
        <div class="invoice-body">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderList as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp. {{ number_format($item->product->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="total">Total</td>
                        <td class="total">Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>

