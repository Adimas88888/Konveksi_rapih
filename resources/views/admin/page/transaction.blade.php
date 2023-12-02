<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <!-- Add your custom styles here if needed -->
</head>
<body>
    <h2>Transaction Report</h2>
    <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Total Transaksi</th>
                <th>Jumlah Barang</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transaksis as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_customer }}</td>
                    <td>{{ $item->total_harga }}</td>
                    <td>{{ $item->total_qty }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
