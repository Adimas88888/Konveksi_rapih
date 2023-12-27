<?php

namespace App\Exports;

use App\Models\transaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransaksiExport implements FromView
{
    public function view(): View
    {
        return view('admin.report.excel', [
            'transaksis' => Transaksi::whereIn('status', ['Paid', 'send'])
                ->orderBy('created_at', 'desc') // Menambahkan orderBy untuk mengurutkan berdasarkan waktu pembuatan (createdAt)
                ->get(),
        ]);
    }
    
}
