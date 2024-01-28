@extends('admin.layout.index')

@section('content')
    <div class="card mb-1">
        <div class="card-body d-flex flex-row justify-content-between">
            <div class="filter d-flex flex-lg-row gap-3">
                <input type="date" class="form-control" name="tgl_awal">
                <input type="date" class="form-control" name="tgl_akhir">
                <button type="button" id="filterBtn" class="btn btn-primary">Filter</button>
            </div>
            <input name="search" type="text" class="form-control w-25" placeholder="Search...">
        </div>
    </div>
    <div class="card rounde-full">
        <div class="card-header bg-transparent ">
            <a href="{{ route('report.excel') }}" class="btn btn-info">
                <i class="fa fa-download"></i>
                <span>Download</span>
            </a>
        </div>
        <div class="row">
            <!-- Widget Total Barang 1 -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Nominal Transaksi</h5>
                        <p class="card-text" id="totalBarangWidget1">Rp {{ number_format($total_transaksi) }}</p>
                    </div>
                </div>
            </div>

            <!-- Widget Total Barang 2 -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Barang</h5>
                        <p class="card-text" id="totalBarangWidget2">{{ $total_qty }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Tanggal</td>
                        <td>Nama Pelanggan</td>
                        <td>Total Transaksi</td>
                        <td>Jumlah Barang</td>
                        <td>Action</td>
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
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td> 
                                <td>{{ $item->nama_customer }}</td>
                                <td>Rp {{ number_format($item->total_harga) }}</td>
                                <td>{{ $item->total_qty }}</td>
                                <td>
                                    <button class="btn btn-danger deleteData" onclick="deleteData({{ $item->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </td>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="pagination d-flex flex-row justify-content-between">
                <div class="showData">
                    Data ditampilkan {{ $transaksis->count() }} dari {{ $transaksis->total() }}
                </div>
                <div>
                    {{ $transaksis->links() }}
                </div>
            </div>
        </div>
        <script>
            function deleteData(idtransaksi) {
                var id = idtransaksi;

                Swal.fire({
                    title: 'Hapus data?',
                    text: 'Kamu yakin untuk menghapus Data ' + ' ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('/admin/deleteTransaksi') }}/" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.success) {
                                    // Assuming each transaksi has a unique identifier, such as a data-id attribute
                                    var deletedItem = $('[data-id="' + id + '"]');

                                    // Remove the deleted item from the UI
                                    deletedItem.remove();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data berhasil dihapus',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat menghapus data',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            }

            $(document).ready(function() {
    $('#filterBtn').click(function() {
        var tgl_awal = $('input[name="tgl_awal"]').val();
        var tgl_akhir = $('input[name="tgl_akhir"]').val();
        var search = $('input[name="search"]').val();

        $.ajax({
            type: "POST",
            url: "{{ route('filterData5') }}",
            data: {
                _token: "{{ csrf_token() }}",
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                search: search,
            },
            success: function(response) {
                // Kosongkan tbody
                $('tbody').empty();

                // Cek jika transaksis tidak kosong
                if (response.transaksis.length > 0) {
                    // Loop melalui setiap transaksi dalam respon
                    $.each(response.transaksis, function(index, transaksi) {
                        // Format tanggal menggunakan fungsi Intl.DateTimeFormat
                        var formattedDate = new Intl.DateTimeFormat('id-ID').format(new Date(transaksi.created_at));

                        // Format total_harga menggunakan fungsi number_format
                        var formattedTotalHarga = 'Rp ' + new Intl.NumberFormat('id-ID').format(transaksi.total_harga);

                        // Bangun baris HTML dan tambahkan ke tbody
                        var row = '<tr class="align-middle">' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td>' + formattedDate + '</td>' +
                            '<td>' + transaksi.nama_customer + '</td>' +
                            '<td>' + formattedTotalHarga + '</td>' +
                            '<td>' + transaksi.total_qty + '</td>' +
                            `<td> <button class="btn btn-danger deleteData" onclick="deleteData(${transaksi.id})">
                                <i class="fas fa-trash-alt"></i>
                            </button></td>` +
                            '</tr>';

                        $('tbody').append(row);
                    });
                } else {
                    // Jika transaksis kosong, tambahkan baris pesan
                    var emptyRow =
                        '<tr class="text-center"><td colspan="5">Belum ada transaksi</td></tr>';
                    $('tbody').append(emptyRow);
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
