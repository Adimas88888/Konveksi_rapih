<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Models\keranjangs;
use App\Models\product;
use App\Models\transaksi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
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

    public function product()
    {
        $Product = product::orderBy('created_at', 'desc')->paginate(6);

        return view('admin.page.product', [
            'product' => $Product,
            'name' => 'Product',
            'title' => 'Admin Product',
            'sku' => 'BRG' . rand(10000, 99999),

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

    // Login admin
    public function login()
    {
        return view('admin.page.login', [
            'name' => 'Login',
            'title' => 'Admin Login',
        ]);
    }

    public function loginProses(Request $request)
    {

        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $user = new User;
        $proses = $user::where('email', $request->email)->first();

        if ($proses) {
            // User found, check if they are an admin
            if ($proses->is_admin === 0) {
                return back()->with('error', 'kamu bukan admin');
            } else {
                // Attempt to authenticate the user
                if (Auth::attempt($dataLogin)) {
                    Alert::toast('success', 'kamu berhasil login');
                    $request->session()->regenerate();

                    return redirect('/admin/dashboard');
                } else {
                    Alert::toast('Email atau Password salah', 'Email atau Password salah');

                    return back()->withErrors(['error' => 'Email dan Password salah']);
                }
            }
        } else {
            // User not found
            return back()->with('error', 'User not found');
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('kamu berhasil logout', 'success');

        return redirect('admin');
    }

    public function reportExcel()
    {
        return Excel::download(new TransaksiExport, 'export transaksi.xlsx');
    }

    public function updateDataUser(Request $request, $id)
    {
        $data = User::findOrFail($id);
        // return $request;
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
            'tgl_lahir' => $request->tglLahir,
            'role' => $request->role,
            'foto' => $filename,
        ];

        $data::where('id', $id)->update($field);
        Alert::toast('Data berhasil diupdate', 'success');
        return redirect()->back();
    }

    public function updateDataUserBiasa()
    {
        $count = auth()->user() ? keranjangs::where('idUser', auth()->user()->id)->where('status', 0)->count() : 0;

        $data = User::where('id', Auth::id())->first();
        $title = 'edit profile';
        return view('pelanggan.page.editProfil', compact('title', 'data', 'count'));
    }
}
