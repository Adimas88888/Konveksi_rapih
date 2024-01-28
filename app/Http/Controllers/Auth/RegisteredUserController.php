<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
      
    

     public function store(Request $request): RedirectResponse
     {
         try {
             $request->validate([
                 'name' => ['required', 'string', 'max:255'],
                 'tlp' => ['required', 'string', 'max:255'],
                 'alamat' => ['required', 'string', 'max:255'],
                 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                 'foto' => ['required', 'image', 'max:10240'],
                 'password' => ['required', 'confirmed', Rules\Password::defaults()],
             ]);
     
             if ($request->hasFile('foto')) {
                 $photo = $request->file('foto');
                 $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
                 $photo->move(public_path('storage/user'), $filename);
                 $request->foto = $filename;
             }
     
             $user = User::create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'tlp' => $request->tlp,
                 'alamat' => $request->alamat,
                 'foto' => $request->foto,
                 'password' => Hash::make($request->password),
                 'is_admin' => 0,
                 'is_mamber' => 1,
             ]);
     
             event(new Registered($user));
             
             // Display success message using SweetAlert toast
             Alert::toast('Registrasi berhasil! Silakan masuk menggunakan akun Anda.', 'success');
     
         } catch (\Throwable $th) {
             info($th);
             // Display error message using SweetAlert toast
             Alert::toast('Registrasi gagal. Silakan coba lagi.', 'error');
         }
     
         return redirect('/login')->with('success', 'Registrasi berhasil! Silakan masuk menggunakan akun Anda.');

     }
     
}
