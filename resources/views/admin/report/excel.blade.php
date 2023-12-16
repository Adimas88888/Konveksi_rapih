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
                <th>No</th>
                <th colspan="2">Tanggal</th>
                <th colspan="2">Nama Pelanggan</th>
                <th colspan="2">Total Transaksi</th>
                <th colspan="2">Jumlah Barang</th>
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
                        <td colspan="2">{{ $item->created_at }}</td>
                        <td colspan="2">{{ $item->nama_customer }}</td>
                        <td colspan="2">{{ $item->total_harga }}</td>
                        <td colspan="2">{{ $item->total_qty }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6">Total</td>
                    <td >{{ $transaksis->sum('total_harga') }}</td>
                    <td colspan="2">{{ $transaksis->sum('total_qty') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
