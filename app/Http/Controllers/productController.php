<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Models\product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class productController extends Controller
{
    public function index()
    {

        $data = product::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.page.product', [
            'name' => 'Product',
            'title' => 'admin Product',
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $data = product::findOrFail($id);

        return view(
            'admin.modal.editModal',
            [
                'title' => 'edit data product',
                'data' => $data,
            ]
        )->render();
    }

    public function addModal()
    {
        return view('admin.modal.addModal', [
            'title' => 'Tambah Data Product',
            'sku' => 'BRG'.rand(10000, 99999),
        ])->render();
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

    public function store(Request $request)
    {
        $data = new product();

        $data->sku = $request->sku;
        $data->nama_product = $request->nama_product;
        $data->type = $request->type;
        $data->kategory = $request->kategory;
        $data->harga = $request->harga;
        $data->quantity = $request->quantity;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd').'_'.$photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        }
        $data->save();
        Alert::toast('Data berhasil disimpan', 'Success');

        return redirect(route('product'));
    }

    // UpdateProductRequest

    public function update(UpdateProductRequest $request, product $product, $id)
    {
        info($request);
        $data = product::findOrFail($id);

        if ($request->file('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd').'_'.$photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        } else {
            $filename = $request->foto;
        }

        $field = [
            'sku' => $request->sku,
            'nama_product' => $request->nama_product,
            'type' => $request->type,
            'kategory' => $request->kategory,
            'harga' => $request->harga,
            'quantity' => $request->quantity,
            'is_active' => 1,
            'foto' => $filename,
        ];
        $data::where('id', $id)->update($field);
        Alert::toast('Data berhasil disimpan', 'Success');

        return redirect(route('product'));

    }

    public function filterData(Request $request)
    {
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $search = $request->search;

        $query = Product::query();

        // Filter berdasarkan tanggal
        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
        }

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('sku', 'like', '%'.$search.'%')
                    ->orWhere('nama_product', 'like', '%'.$search.'%')
                    ->orWhere('type', 'like', '%'.$search.'%');
            });
        }

        // Eksekusi query
        $products = $query->get();

        // Cek apakah hasil query kosong
        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'Data not found',
            ]);
        }

        return response()->json([
            'products' => $products,
        ]);
    }
}
