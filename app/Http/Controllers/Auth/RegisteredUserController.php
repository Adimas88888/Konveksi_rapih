<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
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
                'tgl_lahir' => ['required', 'date'],
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
                'tgl_lahir' => $request->tgl_lahir,
                'foto' => $request->foto,
                'password' => Hash::make($request->password),
                'is_admin' => 0,
                'is_mamber' => 1,
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
    
        } catch (\Throwable $th) {
            info($th);
        }
        return redirect('/');
    }
}
