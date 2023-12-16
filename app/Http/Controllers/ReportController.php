<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi;



class ReportController extends Controller
{

  
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
