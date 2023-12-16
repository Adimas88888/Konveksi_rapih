<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\product;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
class UserController extends Controller
{
    // public function index()
    // {
    //     $data = User::where('is_mamber', 1 )->get();
    //     return view('admin.page.user',[
    //         'name'  => "User Management",
    //         'title' => 'Admin User management',
    //         'data'  => $data,
    //     ]);
    // }


    public function addModalUser()
    {
        return view('admin.modal.modalUser', [
            'title' => 'Tambah Data User',
            'nik' => date('Ymd').rand(000,999),
        ])->render();
    }

    public function store(Request $request)
    {
        $data = new User();
        $data->nik      = $request->nik;
        $data->name     = $request->nama;
        $data->email    = $request->email;
        $data->password = bcrypt($request->password);
        $data->alamat   = $request->alamat;
        $data->tlp      = $request->tlp;
        $data->role     = $request->role;
        $data->tgl_lahir     = $request->tglLahir;
        $data->is_active= 1;
        $data->is_mamber= 0;
        $data->is_admin = 1;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }
        $data->save();
        Alert::success('Data berhasil disimpan', 'Success');
        return redirect(route('user_management'));
    }
    public function show($id)
    {
        $data = User::findOrFail($id);
        // $hasValue = Hash::make($data->password);
        return view(
            'admin.modal.editUser',
            [
                'title' => 'Edit data User',
                'data'  => $data,
                // 'pass'  => (string) $hasValue,
            ]
        )->render();
    }
    public function update(Request $request, $id)
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
        info($request->all());
        $field = [
            'nik'                   => $request->nik,
            'name'                  => $request->name,
            'email'                 => $request->email,
            'alamat'                => $request->alamat,
            'tlp'                   => $request->tlp,
            'tgl_lahir'             => $request->tglLahir,
            'role'                  => $request->role,
            'foto'                  => $filename,
        ];

        $data::where('id', $id)->update($field);
        Alert::toast('Data berhasil diupdate woi', 'success');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $product = User::findOrFail($id);
        $product->delete();

        $json = [
            'success' => "Data berhasil dihapus"
        ];

        echo json_encode($json);
    }


    public function storePelanggan(UserRequest $request)
    {
        $data = new User;
        $nik  = "Member" . rand(000, 999);
        $data->nik          = $nik;
        $data->name         = $request->name;
        $data->email        = $request->email;
        $data->password     = bcrypt($request->password);
        $data->alamat       = $request->alamat . " " . $request->alamat2;
        $data->tlp          = $request->tlp;
        $data->role         = 0;
        $data->tgl_lahir     = $request->date;
        $data->is_active    = 1;
        $data->is_mamber    = 1;
        $data->is_admin     = 0;

        if ($request->hasFile('foto') == "") {
            $filename = "default.png";
            $data->foto = $filename;
        } else {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/user'), $filename);
            $data->foto = $filename;
        }
        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('Home');
    }
    // log in User
    public function loginProses(Request $request)
{
    $dataLogin = [
        'email' => $request->email,
        'password' => $request->password,
    ];

    $user = new User;
    $proses = $user::where('email', $request->email)->first();

    if (!$proses) {
        Alert::toast('Kamu belum register', 'error');
        return back();
    }

    if ($proses->is_active === 0) {
        Alert::toast('Akun belum aktif', 'error');
        return back();
    }

    if (Auth::attempt($dataLogin)) {
        Alert::toast('Kamu berhasil login', 'success');
        $request->session()->regenerate();
        return redirect()->intended('/');
    } else {
        Alert::toast('Email dan Password salah', 'error');
        return back();
    }
}


    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::toast('Kamu berhasil Logout', 'success');
        return redirect('/');
    }
    
    public function chart()
    {
        try {
            $series = [];
            $categories = [];

            foreach(product::get() as $product) {
                $categories[] = $product->type;
                $series[] = $product->quantity;
            }

            return response()->json([
                'series' => $series,
                'categories' => collect($categories)->unique()->toArray(),
            ]);
        } catch (\Throwable $th) {
            info($th);

            return response()->json([
                'message' => 'Gagal memuat chart.',
            ], 500);
        }
    }
    public function chart2()
    {
        try {
            $totalTransaksi = transaksi::orderBy('created_at')->get()->groupBy(function ($item) {
                return $item->created_at->format('M');
            });

            $series = [];
            $categories = [];
    
            foreach ( $totalTransaksi as $key => $transaksi) {
                $categories[] = $key;
                $series[] = $transaksi->sum('total_harga');
            }
    
            info($categories);
            info($series);
    
            return response()->json([
                'series' => $series,
                'categories' => $categories,
            ]);
        } catch (\Throwable $th) {
            info($th);
    
            return response()->json([
                'message' => 'Gagal memuat chart.',
            ], 500);
        }
    }

    public function filterData2(Request $request)
    {
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $search = $request->search;
    
        $query = User::query(); // Ubah dari Product ke User, sesuaikan dengan model User Anda
    
        // Filter berdasarkan tanggal
        if ($tgl_awal && $tgl_akhir) {
            $query->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
        }
    
        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
    
        // Eksekusi query
        $items = $query->get();
    
        // Cek apakah hasil query kosong
        if ($items->isEmpty()) {
            return response()->json([
                'message' => 'Data not found',
            ]);
        }
    
        return response()->json([
            'items' => $items,
        ]);
    }
    
    
}

    

