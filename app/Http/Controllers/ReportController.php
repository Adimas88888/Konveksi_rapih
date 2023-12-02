<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi;
use PDF;


class ReportController extends Controller
{

    public function downloadPDF(Request $request)
    {

        $transaksis = transaksi::all();

        $pdf = PDF ::loadView('transaction', compact('transaksis'));

        return $pdf->download('transaction');
    }

    public function viewPDF(Request $request)
    {

        $transaksis = transaksi::all(); 

        return view('pdf.transaction', compact('transaksis'));
    }
    public function destroy($id)
    {

        $transaksi = transaksi::find($id);
        $transaksi->delete();
        $json = [
            'succes' => "Data berhasil dihapus"
        ];
        echo json_encode($json);
    }
    public function filterData3(Request $request)
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
