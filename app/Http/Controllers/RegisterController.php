<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function view_register(){
        return view('loginsistem.register' , [
            "title" => "Daftar Akun"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:8|max:255',
            'slug' => 'required|unique:users',
            'email' => 'required|unique:users|email:dns',
             'alamat' => 'required|min:8|max:50',
             'no_hp' => 'required|min:11|max:16',
             'password' => 'required|confirmed|min:8|max:20'
         ]);

         $validatedData['password'] = Hash::make($validatedData['password']);
    
         User::create($validatedData);
         return redirect('/')->with('success', 'Berhasil Terdaftar');
    }
}
