<?php

namespace App\Http\Controllers;

use App\Models\keranjangs;
use App\Models\modelDetailTransaksi;
use App\Models\product;
use App\Models\transaksi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $keranjang = keranjangs::where('idUser', auth()->user()->id);
        $countKeranjang = $keranjang->count();
        $code = transaksi::count();
        $codeTransaksi = date('Ymd').$code + 1;
        $detailBelanja = $keranjang->get()->sum('total_price');
        $JumlahBarang = $keranjang->count();
        $qtyBarang = $keranjang->sum('qty');

        return view('pelanggan.page.checkout', [
            'title' => 'Check Out',
            'count' => $countKeranjang,
            'detailBelanja' => $detailBelanja,
            'jumlahbarang' => $JumlahBarang,
            'qtyOrder' => $qtyBarang,
            'codeTransaksi' => $codeTransaksi,
        ]);
    }

    public function prosesCheckout()
    {
        $keranjang = keranjangs::where('idUser', auth()->user()->id)->get();
        // $data = $request->all();
        // $code = transaksi::count();
        // $codeTransaksi = date('Ymd').$code + 1;

        Alert::toast('Checkout Berhasil', 'success');

        return redirect()->route('checkout');
    }

    public function prosesPembayaran(Request $request)
    {
        $data = $request->all();
        $dbTransaksi = new transaksi();

        $dbTransaksi->code_transaksi = $data['code'];
        $dbTransaksi->user_id = auth()->user()->id;
        $dbTransaksi->total_qty = $data['totalQty'];
        $dbTransaksi->total_harga = $data['dibayarkan'];
        $dbTransaksi->nama_customer = $data['namaPenerima'];
        $dbTransaksi->alamat = $data['alamatpenerima'];
        $dbTransaksi->no_tlp = $data['tlp'];
        // $dbTransaksi->provinsi = $data['provincy'];
        // $dbTransaksi->kota = $data['destination'];
        // $dbTransaksi->jasa = $data['service'];
        $dbTransaksi->ekspedisi = $data['ekspedisi'];

        $dbTransaksi->save();

        $dataCart = keranjangs::where('idUser', auth()->user()->id)->get();
        foreach ($dataCart as $item) {
            $detailtransaksi = new modelDetailTransaksi();
            $filedDetail = [
                'id_transaksi' => $data['code'],
                'id_barang' => $item['id_barang'],
                'qty' => $item['qty'],
                'price' => $item['price'],
            ];

            $detailtransaksi::create($filedDetail);

            $filedCart = [
                'qty' => $item['qty'],
                'price' => $item['price'],
                'status' => 1,
            ];

            $item->update($filedCart);

            $idProduct = product::where('id', $item->id_barang)->first();
            $idProduct->quantity = $idProduct->quantity - $item->qty;
            $idProduct->quantity_out = $idProduct->quantity_out + $item->qty;
            $idProduct->save();
        }

        Alert::alert()->success('Berhasil disimpan', 'Lanjut pembayaran');

        return redirect()->route('keranjang');

    }

    public function bayar($id)
    {
        $find_data = transaksi::find($id);
        $uniqueString = uniqid();
        $find_data->code_transaksi = $uniqueString;
        $find_data->update();

        $countKeranjang = auth()->user() ? keranjangs::where('idUser', auth()->user()->id)->where('status', 0)->count() : 0;
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $uniqueString,
                'gross_amount' => $find_data->total_harga,
            ],
            'customer_details' => [
                'first_name' => 'Mr',
                'last_name' => $find_data->nama_customer,
                'phone' => $find_data->no_tlp,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('pelanggan.page.detailTransaksi', [
            'name' => 'Detail Transaksi',
            'title' => 'Detail Transaksi',
            'count' => $countKeranjang,
            'token' => $snapToken,
            'data' => $find_data,
        ]);
    }

    public function suksesBayar(Request $request)
    {
        if ($request->transaction_status == 'settlement') {
            $validatedTransaction = transaksi::where('code_transaksi', $request->order_id)->first();
            $validatedTransaction->update([
                'status' => 'paid',
            ]);
        }
    }
}
