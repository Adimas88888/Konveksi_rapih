<?php

namespace App\Http\Controllers;

use App\Models\keranjangs;
use App\Models\product;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function transaksi()
    {
        // $count_Trx = auth()->user() ? transaksi::where('user_id', auth()->user()->id)->where('status', 'Unpaid')->count() : 0;
        $countKeranjang = auth()->user() ? keranjangs::where('idUser', auth()->user()->id)->where('status', 0)->count() : 0;
        $db = auth()->user() ? keranjangs::with('product')->where('idUser', auth()->user()->id)->where('status', 0)->get() : [];

        return view('pelanggan.page.transaksi', [
            'title' => 'Transaksi',
            'data' => $db,
            'count' => $countKeranjang,
            // 'counttrx'=> $count_Trx,
        ]);
    }

    public function deleteDataDetail($id)
    {
        $db = keranjangs::where('id', $id)->delete();

        return response([
            'status' => true,
        ]);
    }

    public function addTocart(Request $request)
    {
        $idProduct = $request->input('product_id');

        $db = new keranjangs;
        $product = product::findOrFail($idProduct);

        if (keranjangs::where('idUser', auth()->user()->id)
            ->where('id_barang', $idProduct)
            ->where('status', 0)
            ->exists()
        ) {
            $db = keranjangs::where('id_barang', $idProduct)->first();
            $db->qty = $db->qty + 1;
            $db->save();
        } else {
            $field = [
                'idUser' => auth()->user()->id,
                'id_barang' => $idProduct,
                'qty' => 1,
                'price' => $product->harga,
            ];

            $db::create($field);
        }

        return redirect()->back();

    }

    public function destroy($id)
    {

        $product = product::find($id);
        $product->delete();
        $json = [
            'succes' => 'Data berhasil dihapus',
        ];
        echo json_encode($json);
    }
}
