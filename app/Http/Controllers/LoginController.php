<?php

namespace App\Http\Controllers;

use App\Models\Konten;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){

      $ktn = "";
      $pesan = Konten::all();
      foreach($pesan as $psn){
       $ktn = $psn->pesan_login;
      }
      if(!$ktn){
        
        $konten = "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Rerum ex doloremque necessitatibus vitae ullam distinctio voluptate at ratione provident natus nemo perspiciatis autem quisquam nobis ab aut, facere dignissimos voluptatibus animi adipisci excepturi accusantium. Earum dolorem consectetur eveniet et cumque accusantium nesciunt, quas facere cum placeat molestias mollitia doloribus, vero error amet rem quos temporibus fuga ratione minima similique. Eveniet alias dolor sunt soluta cum ad iste laboriosam mollitia sapiente enim ea vitae, dicta voluptatum ipsa, quam neque fugiat voluptate, veritatis distinctio commodi praesentium ducimus inventore? Porro perspiciatis facere magni officiis, explicabo recusandae distinctio deleniti suscipit quas, cumque commodi adipisci?";
      }

      $konten = $ktn;
      
        return view('loginsistem.login', [
            "title" => "Login User",
            "konten" => $konten
        ]);
      }

      public function authenticate(Request $request)
      {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('failLogin' , 'Email atau password salah');

      }

      public function logout(Request $request)
      {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');

      }
}
