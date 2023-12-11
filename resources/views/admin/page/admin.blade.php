@extends('admin.layout.index')

@section('content')
    <div class="card mb-1">
        <div class="card-body d-flex flex-row justify-content-between">
            <div class="filter d-flex flex-lg-row gap-3">
                <input type="date" class="form-control" name="tgl_awal">
                <input type="date" class="form-control" name="tgl_akhir">
                <button class="btn btn-primary">Filter</button>
            </div>
            <input type="text" class="form-control w-25" placeholder="Search...">
        </div>
    </div>
    <div class="card rounde-full">
        <div class="card-header bg-transparent ">
            <button class="btn btn-info" data-bs-toggle="modal" id="addData">
                <i class="fa fa-plus">
                    <span>Tambah User</span>
                </i>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Masuk</th>
                           
                            <th>Nama Karyawan</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>
                                    <img src="{{ asset('storage/user/' . $item->foto) }}" alt="Gambar Product"
                                        style="width:100px;">
                                </td> --}}
                               
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <span
                                        class='badge text-bg-{{ $item->role === 1 ? 'info' : 'success' }}'>{{ $item->role === 1 ? 'Admin' : 'Member' }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ $item->is_active === 1 ? 'success' : 'danger' }}">{{ $item->is_active === 1 ? 'Active' : 'No Active' }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-info editModal" data-id="{{ $item->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger deleteData" data-id="{{ $item->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination d-flex flex-row justify-content-between">
                <div class="showData">
                    Data ditampilkan {{ $data->count() }} dari {{ $data->total() }}
                </div>
                <div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="tampilData" style="display: none;"></div>
    <div class="tampilEditData" style="display: none;"></div>

    {{-- <script>
        $('#addData').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('addModal.user') }}',
                success: function(response) {
                    $('.tampilData').html(response).show();
                    $('#userTambah').modal("show");
                }
            });
        });
        $('.editModal').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                url: "{{ route('showDataUser', ['id' => ':id']) }}".replace(':id', id),
                success: function(response) {
                    $('.tampilEditData').html(response).show();
                    $('#editModal').modal("show");
                }
            });
        });

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $('.deleteData').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var nik = $('#nik').val();
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
                text: "Kamu yakin untuk menghapus karyawan ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('destroyDataUser', ['id' => ':id']) }}".replace(':id', id),
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                Toast.fire({
                                    icon: "success",
                                    title: response.success,
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Tampilkan notifikasi error jika terjadi kesalahan
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
            $('button.btn-primary').click(function() {
                var tgl_awal = $('input[name="tgl_awal"]').val();
                var tgl_akhir = $('input[name="tgl_akhir"]').val();
                var search = $('input.w-25').val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('filterData2') }}",
                    data: {
                        tgl_awal: tgl_awal,
                        tgl_akhir: tgl_akhir,
                        search: search,
                    },
                    success: function(response) {
                        // Kosongkan tbody
                        $('tbody').empty();

                        // Cek jika data tidak kosong
                        if (response.items.length > 0) {
                            // Loop melalui setiap data dalam respon
                            $.each(response.items, function(index, item) {
                                // Bangun baris HTML dan tambahkan ke tbody
                                var row = '<tr class="align-middle">' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td><img src="{{ asset('storage/user') }}/' +
                                    item.foto +
                                    '" alt="Gambar Product" style="width:100px;"></td>' +
                                    '<td>' + item.nik + '</td>' +
                                    '<td>' + item.created_at + '</td>' +
                                    '<td>' + item.name + '</td>' +
                                    '<td><span class="badge text-bg-' +
                                    (item.role === 1 ? 'info' : 'success') + '">' +
                                    (item.role === 1 ? 'Admin' : 'Member') +
                                    '</span></td>' +
                                    '<td><span class="badge text-bg-' +
                                    (item.is_active === 1 ? 'success' : 'danger') +
                                    '">' +
                                    (item.is_active === 1 ? 'Active' : 'No Active') +
                                    '</span></td>' +
                                    '<td class="text-center">' +
                                    '<button class="btn btn-info editModal" data-id="' +
                                    item.id +
                                    '"><i class="fas fa-edit"></i></button>' +
                                    '<button class="btn btn-danger deleteData" data-id="' +
                                    item.id +
                                    '"><i class="fas fa-trash-alt"></i></button>' +
                                    '</td>' +
                                    '</tr>';

                                $('tbody').append(row);
                            }); 
                        } else {
                            // Jika data kosong, tambahkan baris pesan
                            var emptyRow =
                                '<tr class="text-center"><td colspan="8">Belum ada data</td></tr>';
                            $('tbody').append(emptyRow);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
@endsection
