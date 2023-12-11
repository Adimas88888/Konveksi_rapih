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
            <a href="{{ route('report.excel') }}" class="btn btn-info" onclick="window.location.href='/admin/download-pdf'">
                <i class="fa fa-download"></i>
                <span>Download</span>
            </a>
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
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->nama_customer }}</td>
                                <td>{{ $item->total_harga }}</td>
                                <td>{{ $item->total_qty }}</td>
                                <td>
                                    <button class="btn btn-danger deleteData" onclick="deleteData({{ $item->id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                </td>
                        @endforeach
                    @endif
                            </tbody>

                    <script>
                        document.getElementById('downloadButton').addEventListener('click', function() {
                            // Create an AJAX request to trigger the download
                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', '/admin/download-pdf', true);
                            xhr.responseType = 'blob'; // Set the response type to blob

                            xhr.onload = function() {
                                // Check if the request was successful
                                if (this.status === 200) {
                                    // Create a Blob from the response
                                    var blob = new Blob([this.response], {
                                        type: 'application/pdf'
                                    });

                                    // Create a download link and trigger the download
                                    var downloadLink = document.createElement('a');
                                    downloadLink.href = window.URL.createObjectURL(blob);
                                    downloadLink.download = 'transactions.pdf';
                                    downloadLink.click();
                                }
                            };

                            // Send the request
                            xhr.send();
                        });


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
                                    type: "POST", // Ganti menjadi POST karena Anda mengirim data sensitif
                                    url: "{{ route('filterData3') }}", // Sesuaikan dengan nama rute yang Anda tentukan di Laravel
                                    data: {
                                        _token: "{{ csrf_token() }}", // Tambahkan token CSRF untuk keamanan
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
                                                // Bangun baris HTML dan tambahkan ke tbody
                                                var row = '<tr class="align-middle">' +
                                                    '<td>' + (index + 1) + '</td>' +
                                                    '<td>' + transaksi.nama_customer + '</td>' +
                                                    '<td>' + transaksi.total_harga + '</td>' +
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
