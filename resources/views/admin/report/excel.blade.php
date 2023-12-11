<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>No</td>
                <td>Tanggal</td>
                <td>Nama Pelanggan</td>
                <td>Total Transaksi</td>
                <td>Jumlah Barang</td>
            </tr>
        </thead>
        <tbody>
            @if ($transaksis->isEmpty())
                <tr class="text-center">
                    <td colspan="9">Belum ada transaksi</td>
                </tr>
            @else
                @foreach ($transaksis as $item)
                    <tr class="align-middle">

                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->nama_customer }}</td>
                        <td>{{ $item->total_harga }}</td>
                        <td>{{ $item->total_qty }}</td>
                @endforeach
                <tr>
                    <td colspan="3">Total</td>
                    <td>{{ $transaksis->sum('total_harga') }}</td>
                    <td>{{ $transaksis->sum('total_qty') }}</td>
                </tr>
            @endif
                </tbody>
    </table>
</body>
</html>