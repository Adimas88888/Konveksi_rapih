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
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $search = $request->search;

        // Gunakan closure untuk menyatukan kondisi OR antara 'Paid' dan 'Send'
        $query = Transaksi::query()->where(function ($query) {
            $query->where('status', 'Paid')->orWhere('status', 'Send');
        });

        // Tambahkan kondisi untuk rentang tanggal jika tgl_awal dan tgl_akhir ada
        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
        }

        // Tambahkan kondisi pencarian jika ada data pencarian
        if ($search) {
            $query->where('nama_customer', 'like', '%' . $search . '%');
        }

        // Ambil data transaksi sesuai kondisi-kondisi yang telah ditetapkan
        $transaksis = $query->get();

        // Jika tidak ada data transaksi yang ditemukan, kembalikan pesan
        if ($transaksis->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ]);
        }

        // Jika ada data transaksi, kembalikan data transaksi dalam format JSON
        return response()->json([
            'transaksis' => $transaksis
        ]);
    }

}
