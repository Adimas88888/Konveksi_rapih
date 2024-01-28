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
                    @foreach ($allTrx as $trx)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trx->nama_customer }}</td>
                            <td>{{ $trx->total_qty }}</td>
                            <td>Rp {{ number_format($trx->total_harga) }}</td>
                            <td>{{ $trx->ekspedisi }}</td>
                            <td class="badge text-bg-success">
                                <select name="status" class="text-bg-success" id="status"
                                    onchange="updateTransaction('{{ route('updateTransaksi', $trx->id) }}', this)">
                                    <option value="Send" {{ $trx->status == 'Send' ? 'selected' : '' }}
                                        class="text-bg-success">Send</option>
                                    <option value="Paid" {{ $trx->status == 'Paid' ? 'selected' : '' }}
                                        class="text-bg-success">Paid</option>
                                </select>
                            </td>
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
            function updateTransaction(url, element) {
                var status = $(element).val();

                // Menggunakan SweetAlert untuk konfirmasi
                Swal.fire({
                    title: 'Anda yakin ingin mengubah status?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengklik "Ya"
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "status": status
                            },
                            success: function(res) {
                                console.log(res);
                                // Tambahkan alert atau pesan berhasil di sini jika perlu
                            },
                            error: function(res) {
                                console.log('gagal');
                                // Tambahkan alert atau pesan error di sini jika perlu
                            }
                        });
                    }
                });
            }

            $(document).ready(function() {
                $('#filter_tgl').click(function() {
                    var tgl_awal = $('#tgl_awal').val();
                    var tgl_akhir = $('#tgl_akhir').val();
                    var search = $('#search').val();

                    $.ajax({
                        type: "POST",
                        url: "{{ route('filterData4') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            tgl_awal: tgl_awal,
                            tgl_akhir: tgl_akhir,
                            search: search,
                        },
                        success: function(response) {
                            console.log(response);
                            // Kosongkan tbody
                            $('#trxTable tbody').empty();
                            // Cek jika transaksi tidak kosong
                            if (response.transaksis.length > 0) {
                                // Loop melalui setiap transaksi dalam respon
                                $.each(response.transaksis, function(index, transaction) {
                                    // Format total_harga menggunakan fungsi toLocaleString
                                    var formattedTotalHarga = parseFloat(transaction
                                        .total_harga).toLocaleString('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    });

                                    // Bangun baris HTML dan tambahkan ke tbody
                                    var row = '<tr class="align-middle">' +
                                        '<td>' + (index + 1) + '</td>' +
                                        '<td>' + transaction.nama_customer + '</td>' +
                                        '<td>' + transaction.total_qty + '</td>' +
                                        '<td>' + formattedTotalHarga + '</td>' +
                                        '<td>' + transaction.ekspedisi + '</td>' +
                                        '<td>' + ` <select name="status" class="text-bg-success" id="status" onchange="updateTransaction('${transaction.url_update}', this)">
                        <option value="Send" ${transaction.status == 'Send' ? 'selected' : ''} >Send</option>
                        <option value="Paid" ${transaction.status == 'Paid' ? 'selected' : ''} >Paid</option>
                      </select>` + '</td>' +
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
