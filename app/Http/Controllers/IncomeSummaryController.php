<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\Http\Request;

class IncomeSummaryController extends Controller
{
    public function incomesummary()
    {
       
        $allTrx = Transaksi::where('status', 'unpaid')
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return view('admin.page.income-summary', [
            'name' => "Income-Summary",
            'title' => 'Admin Income-Summary',
            'allTrx' => $allTrx,
        ]);
    }

    public function filterData3(Request $request)
    {
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $search = $request->search;

        $query = transaksi::query()->where('status', 'Unpaid');

        // Filter berdasarkan tanggal
        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_customer', 'like', '%' . $search . '%')
                    ->orWhere('total_qty', 'like', '%' . $search . '%')
                    ->orWhere('total_harga', 'like', '%' . $search . '%')
                    ->orWhere('ekspedisi', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        // Eksekusi query
        $transactions = $query->get();

        // Cek apakah hasil query kosong
        if ($transactions->isEmpty()) {
            return response()->json([
                // 'transactions'=> [],
                'message' => 'Data not found',
            ]);
        }

        return response()->json([
            'transactions' => $transactions,
        ]);
    }
}
