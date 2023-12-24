@extends('pelanggan.layout.index')

@section('conten')
    <div class="container-fluid mt-5">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Payment List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Id Transaksi</th>
                                <th>Nama Penerima</th>
                                <th>Total Transaksi</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle text-center">
                            @foreach ($data as $x => $item)
                                <tr>
                                    <td>{{ ++$x }}</td>
                                    <td>{{ $item->code_transaksi }}</td>
                                    <td>{{ $item->nama_customer }}</td>
                                    <td>{{ $item->total_harga }}</td>
                                    <td>
                                        @if ($item->status === 'Unpaid' && $item->created_at >= now()->subDay())
                                            <span class="badge text-bg-danger">Unpaid</span>
                                        @elseif ($item->status === 'Unpaid' && $item->created_at <= now()->subDay())
                                            <span class="badge text-bg-danger">Batal</span>
                                        @elseif($item->status === 'Send')
                                            <span class="badge text-bg-success">Send</span>
                                        @elseif($item->status === 'Paid')
                                            <span class="badge text-bg-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status !== 'Unpaid' || $item->created_at <= now()->subDay())
                                            <button class="btn btn-success" disabled>Bayar</button>
                                        @else
                                            <a href="{{ route('keranjang.bayar', ['id' => $item->id]) }}"
                                                class="btn btn-success">Bayar</a>
                                        @endif
                                        {{-- @if ($item->status === 'Unpaid' && $item->created_at >= now()->subDay())
                                        <a href="{{ route('keranjang.bayar', ['id' => $item->id]) }}" class="btn btn-success">Bayar</a>
                                    @else
                                        <button class="btn btn-success" disabled>Bayar</button>
                                    @endif --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
