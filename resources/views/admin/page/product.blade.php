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
            <button class="btn btn-info" data-bs-toggle="modal" id="addData">
                <i class="fa fa-plus">
                    <span>Tambah Product</span>
                </i>
            </button>
        </div>
        <div class="card-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Foto</td>
                        <td>Tanggal</td>
                        <td>SKU</td>
                        <td>Product Name</td>
                        <td>Category</td>
                        <td>Price</td>
                        <td>Stock</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @if ($product->isEmpty())
                        <tr class="text-center">
                            <td colspan="9">Belum ada barang</td>
                        </tr>
                    @else
                        @foreach ($product as $item)
                            <tr class="align-middle">

                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/product/' . $item->foto) }}" alt="Gambar Product"
                                        style="width:100px;">

                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->nama_product }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->harga }}</td>
                                <td>{{ $item->quantity }}</td>

                                <td>
                                    <button class="btn btn-info editModal" data-id="{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger deleteData" data-id="{{ $item->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="pagination d-flex flex-row justify-content-between">
                <div class="showData">
                    Data ditampilkan {{ $product->count() }} dari {{ $product->total() }}
                </div>
                <div>
                    {{ $product->links() }}
                </div>
            </div>
        </div>
        <div class="tampilData" style="display: none;"></div>
        <div class="tampilEditData" style="display: none;"></div>

        <script>
            $('#addData').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('addModal') }}",
                    success: function(response) {
                        $('.tampilData').html(response).show();
                        $('#addModal').modal("show");
                    }
                });
            });
            $('.editModal').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id')

                $.ajax({
                    type: "Get",
                    url: "{{ route('editModal', ['id' => ':id']) }}".replace(':id', id),
                    success: function(response) {
                        $('.tampilEditData').html(response).show();
                        $('#editModal').modal("show");
                    }
                });
            });
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            })
            $('.deleteData').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var sku = $('#sku').val();
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                });

                Swal.fire({
                    title: 'Hapus data ?',
                    text: "Kamu yakin untuk menghapus SKU " + sku + " ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('deleteData', ['id' => ':id']) }}".replace(':id', id),
                            dataType: "json",
                            success: function(response) {
                                if (response) {
                                    Toast.fire({
                                        icon: "success",
                                        title: 'Behasil',
                                        text: 'Behasil hapus data',
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
                })
            });
            
            $(document).ready(function() {
                $('#filter_tgl').click(function() {
                    var tgl_awal = $('#tgl_awal').val();
                    var tgl_akhir = $('#tgl_akhir').val();
                    var search = $('#search').val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('filterData') }}",
                        data: {
                            tgl_awal: tgl_awal,
                            tgl_akhir: tgl_akhir,
                            search: search,
                        },
                        success: function(response) {
                            // Kosongkan tbody
                            $('tbody').empty();

                            // Cek jika products tidak kosong
                            if (response.products.length > 0) {
                                // Loop melalui setiap product dalam respon
                                $.each(response.products, function(index, product) {
                                    // Bangun baris HTML dan tambahkan ke tbody
                                    var row = '<tr class="align-middle">' +
                                        '<td>' + (index + 1) + '</td>' +
                                        '<td><img src="{{ asset('storage/product') }}/' +
                                        product.foto +
                                        '" alt="Gambar Product" style="width:100px;"></td>' +
                                        '<td>' + product.created_at + '</td>' +
                                        '<td>' + product.sku + '</td>' +
                                        '<td>' + product.nama_product + '</td>' +
                                        '<td>' + product.type + '</td>' +
                                        '<td>' + product.harga + '</td>' +
                                        '<td>' + product.quantity + '</td>' +
                                        '<td>' +
                                        '<button class="btn btn-info editModal" data-id="' +
                                        product.id +
                                        '"><i class="fas fa-edit"></i></button>' +
                                        '<button class="btn btn-danger deleteData" data-id="' +
                                        product.id +
                                        '"><i class="fas fa-trash-alt"></i></button>' +
                                        '</td>' +
                                        '</tr>';

                                    $('tbody').append(row);
                                });
                            } else {
                                // Jika products kosong, tambahkan baris pesan
                                var emptyRow =
                                    '<tr class="text-center"><td colspan="9">Belum ada barang</td></tr>';
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
