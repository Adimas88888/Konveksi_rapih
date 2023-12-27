<?php

namespace App\Http\Controllers;


use App\Models\keranjangs;
use App\Models\product;
use App\Models\transaksi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $best = Product::where('quantity_out', '>=', 5)
            ->where('quantity', '>', 0)
            ->get();
        $data = Product::where('quantity', '>', 0)->paginate(10);
        $countKeranjang = auth()->user() ? keranjangs::where('idUser', auth()->user()->id)->where('status', 0)->count() : 0;

        return view('pelanggan.page.home', [
            'title' => 'Home',
            'data' => $data,
            'best' => $best,
            'count' => $countKeranjang,
        ]);
    }

    public function shop(Request $request)
    {
        $data = Product::when($request->type && $request->category, function ($query) use ($request) {
            return $query->where('type', $request->type)->where('kategory', $request->category);
        })
            ->where('quantity', '>', 0)
            ->paginate(8);
        $countKeranjang = auth()->user() ? keranjangs::where('idUser', auth()->user()->id)->where('status', 0)->count() : 0;

        return view('pelanggan.page.shop', [
            'title' => 'Shop',
            'data' => $data,
            'count' => $countKeranjang,
        ]);
    }

    public function contact()
    {
        $countKeranjang = auth()->user() ? keranjangs::where('idUser', auth()->user()->id)->where('status', 0)->count() : 0;

        return view('pelanggan.page.contact', [
            'title' => 'Contact Us',
            'count' => $countKeranjang,
        ]);
    }

    public function admin()
    {

        $Transaksi = Transaksi::count();
        $total_transaksi = Transaksi::whereMonth('created_at', now()->month)->sum('total_harga');
        $Product = Product::count();
        $User = User::count();
        return view('admin.page.dashboard', [
            'name' => 'Dashboard',
            'title' => 'Admin Dashboard',
            'User' => $User,
            'Product' => $Product,
            'Transaksi' => $Transaksi,
            'total_transaksi' => $total_transaksi,
        ]);
    }

   
    public function userManagement()
    {

        $data = User::where('is_mamber', 1)->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.page.user', [
            'name' => 'User Management',
            'title' => 'Admin User management',
            'data' => $data,
        ]);
    }

   

    public function keranjang()
    {
        $countKeranjang = auth()->user()
            ? keranjangs::where('idUser', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->where('status', 0)
                ->count()
            : 0;
        $all_trx = auth()->user()
            ? transaksi::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get()
            : [];

        return view('pelanggan.page.keranjang', [
            'name' => 'Payment',
            'title' => 'Payment Process',
            'count' => $countKeranjang,
            'data' => $all_trx,
        ]);
    }


    public function updateDataUser(Request $request, $id)
    {
        $data = User::findOrFail($id);
       
        if ($request->file('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        } else {
            $filename = $data->foto;
        }
        
        $field = [
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'alamat' => $request->alamat,
            'tlp' => $request->tlp,
            // 'tgl_lahir' => $request->tglLahir,
            'role' => $request->role,
            'foto' => $filename,
        ];

        $data::where('id', $id)->update($field);
        Alert::toast('Data berhasil diupdate', 'success');
        return redirect()->back();
    }

    public function updateDataUserBiasa()
    {
        $count = auth()->user() ?
         keranjangs::where('idUser', auth()->user()->id)->where('status', 0)->count() 
         : 0;

        $data = User::where('id', Auth::id())->first();
        $title = 'edit profile';
        return view('pelanggan.page.editProfil', compact('title', 'data', 'count'));
    }
}
