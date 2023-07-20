<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function view_dashboard(Request $request)
   {
    $barangs = Barang::orderBy('created_at' , 'DESC');
    $request->session()->forget('gross');
    if($request->search){
        $barangs = Barang::where('nama_barang' , 'like' , '%' . $request->search . '%')->orderBy('created_at' , 'DESC');
    }

    $users = User::where('id' , auth()->user()->id)->get();
    return view('dashboard', [
        "title" => "Dashboard",
        "barangs" => $barangs->with('supplier')->paginate(9)->withQueryString(),
        "users" => $users
    ]);
   }
  
  
}
