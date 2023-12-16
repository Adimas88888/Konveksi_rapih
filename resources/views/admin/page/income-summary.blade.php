@extends('admin.layout.index')

@section('content')
<div class="card mb-1">
    <div class="card-body d-flex flex-row justify-content-between">
        <div class="filter d-flex flex-lg-row gap-3">
            <input type="date" class="form-control" name="tgl_awal" id="tgl_awal">
            <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir">
            <button type="button" class="btn btn-primary" id="filter_tgl">Filter</button>
        </div>
        <input type="text" class="form-control w-25" placeholder="Search..." id="search">
    </div>
</div>
<div class="card rounde-full">
    <div class="card-header bg-transparent ">
    </div>
    <div class="card-body">
        <table class="table table-responsive table-striped" id="trxTable">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Pelanggan</td>
                    <td>Jumlah Barang</td>
                    <td>Total harga</td>
                    <td>ekspedisi</td>
                    <td>status</td>  
                </tr>
            </thead>
            <tbody>
                @foreach($allTrx as $trx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trx->nama_customer }}</td>
                    <td>{{ $trx->total_qty }}</td>
                    <td>{{ $trx->total_harga }}</td>
                    <td>{{ $trx->ekspedisi }}</td>
                    <td>{{ $trx->created_at >= now()->subDay() ? $trx->status : 'Batal' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination d-flex flex-row justify-content-between">
            <div class="showData">
                Data ditampilkan {{ $allTrx->count() }} dari {{ $allTrx->total() }}
            </div>
            <div>
                {{ $allTrx->links() }}
            </div>
        </div>
    </div>
        <script>
            $(document).ready(function() {
                $('#filter_tgl').click(function() {
                    var tgl_awal = $('#tgl_awal').val();
                    var tgl_akhir = $('#tgl_akhir').val();
                    var search = $('#search').val();
    
                    $.ajax({
                        type: "POST",
                        url: "{{ route('filterData3') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            tgl_awal: tgl_awal,
                            tgl_akhir: tgl_akhir,
                            search: search,
                        },
                        success: function(response) {
                            
                            // Kosongkan tbody
                            $('#trxTable tbody').empty();
    
                            // Cek jika transaksi tidak kosong
                            if (response.transactions.length > 0) {
                                // Loop melalui setiap transaksi dalam respon
                                $.each(response.transactions, function(index, transaction) {
                                    // Bangun baris HTML dan tambahkan ke tbody
                                    var row = '<tr class="align-middle">' +
                                        '<td>' + (index + 1) + '</td>' +
                                        '<td>' + transaction.nama_customer + '</td>' +
                                        '<td>' + transaction.total_qty + '</td>' +
                                        '<td>' + transaction.total_harga + '</td>' +
                                        '<td>' + transaction.ekspedisi + '</td>' +
                                        '<td>' + (new Date(transaction.created_at) >= new Date(new Date().setDate(new Date().getDate() - 1)) ? transaction.status : 'Batal') + '</td>' +
                                        '</tr>';
    
                                    $('#trxTable tbody').append(row);
                                });
                            } else {
                                // Jika transaksi kosong, tambahkan baris pesan
                                var emptyRow =
                                    '<tr class="text-center"><td colspan="6">Belum ada transaksi</td></tr>';
                                $('#trxTable tbody').append(emptyRow);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
@endsection