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
        $total_transaksi = Transaksi::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total_harga');

        $total_qty = Transaksi::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->sum('total_qty');

        $transaksi = transaksi::where('status', 'paid')
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

        $query = Transaksi::query();


        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
        }
        if ($search) {
            $query->where('nama_customer', 'like', '%' . $search . '%');
        }
        $transaksis = $query->get();

        if ($transaksis->isEmpty()) {
            return response()->json([
                'message' => 'Data not found',
            ]);
        }
        return response()->json([
            'transaksis' => $transaksis
        ]);
    }
 
}
