<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminManagement()
    {
        $data = User::where('is_admin', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.page.admin', [
            'name' => 'Admin Management',
            'title' => 'Admin admin management',
            'data' => $data,
        ]);
    }
}
