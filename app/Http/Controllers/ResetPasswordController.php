<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller

    {
        public function reset()
        {
                return view('admin.page.reset-password', [
                    'name' => "reset-password",
                    'title' => 'Admin Login',
                ]);
        }
    
        public function resetPassword(Request $request)
        {
            // Validasi formulir
            $request->validate([
                'email' => 'required|email',
                'new_password' => 'required|min:6',
            ]);
    
            // Cari pengguna dengan email yang sesuai
            $user = User::where('email', $request->email)->first();
    
            // Jika pengguna tidak ditemukan
            if (!$user) {
                return redirect()->back()->with('error', 'Email not found');
            }
    
            // Reset password pengguna
            $user->update([
                'password' => bcrypt($request->new_password)
            ]);
    
            // Redirect dengan pesan sukses
            return redirect()->route('login')->with('success', 'Password has been reset successfully. Please login with your new password.');
        }
    }

