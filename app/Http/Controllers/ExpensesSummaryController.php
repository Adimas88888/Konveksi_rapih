<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Illuminate\Http\Request;

class ExpensesSummaryController extends Controller
{
    public function expensesSummary()
    {

        $allTrx = Transaksi::where('status', 'paid')
            ->orWhere('status', 'send')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.page.expenses-summary', [
            'name' => "Expenses-Summary",
            'title' => 'Admin Expenses-Summary',
            'allTrx' => $allTrx,
        ]);
    }

    public function updateStatus(transaksi $transaksi, Request $request, )
    {
        $status = $request->status;
        try {

            $transaksi->update(
                ['status' => $status]
            );
            return response()->json(
                [
                    'message' => 'data berhasil diubah'
                ]
            );
        } catch (\Throwable $th) {
            info($th);
        }



    }

    public function filterData4(Request $request)
    {
        info($request);
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $search = $request->search;

        $query = transaksi::query()->where('status', 'Paid')->orWhere('status', 'Send');

        // Filter berdasarkan tanggal
        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
        }

        // Filter berdasarkan pencarian
        if ($search) {
                $query->where('nama_customer', 'like', '%' . $search . '%')
                    ->orWhere('total_qty', 'like', '%' . $search . '%')
                    ->orWhere('total_harga', 'like', '%' . $search . '%')
                    ->orWhere('ekspedisi', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
        }

        // Eksekusi query
        $transactions = $query->get();

        // Cek apakah hasil query kosong
        if ($transactions->isEmpty()) {
            return response()->json([
                'transactions' => [],
                'message' => 'Data not found',
            ]);
        }

        foreach ($transactions as $key => $value) {
            $value['url_update'] = route('updateTransaksi', $value->id);
        }
        return response()->json([
            'transactions' => $transactions,
            
        ]);
    }
}
