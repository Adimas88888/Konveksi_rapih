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
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Pelanggan</td>
                    <td>Total Transaksi</td>
                    <td>Jumlah Barang</td>
                    <td>Status</td>
                    <td>Action</td>
                </tr>
            </thead>
@endsection