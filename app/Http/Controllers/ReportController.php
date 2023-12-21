<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use Illuminate\Http\Request;
use App\Models\transaksi;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    public function report()
    {

        $total_transaksi = Transaksi::where(function ($query) {
            $query->where('status', 'paid')
                ->whereMonth('created_at', now()->month);
        })
            ->orWhere(function ($query) {
                $query->where('status', 'send')
                    ->whereMonth('created_at', now()->month);
            })
            ->sum('total_harga');

        $total_qty = Transaksi::where(function ($query) {
            $query->where('status', 'paid')
                ->whereMonth('created_at', now()->month);
        })
            ->orWhere(function ($query) {
                $query->where('status', 'send')
                    ->whereMonth('created_at', now()->month);
            })
            ->sum('total_qty');


        $transaksi = transaksi::where('status', 'paid')
            ->orWhere('status', 'send')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.page.report', [
            'name' => 'Report',
            'title' => 'Admin Report',
            'transaksis' => $transaksi,
            'total_qty' => $total_qty,
            'total_transaksi' => $total_transaksi,
        ]);
    }


    public function reportExcel()
    {
        return Excel::download(new TransaksiExport, 'export transaksi.xlsx');
    }

    public function filterData5(Request $request)
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
