<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
       $users = $user::where('role' , '!=' , '3')->where('id' , '!=' , auth()->user()->id)->latest();

        if($request->search){
            $users->where('nama', 'like', '%'. $request->search . '%');
        }
        $path =  session()->put('path', Route::current()->getName());
        return view('dashboard.user.user_view', [
            "title" => "All User",
            "users" => $users->paginate(10)->withQueryString(),
            "path" => $path
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user.create_user', [
            "title" => "All User"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
           'nama' => 'required|min:8|max:255',
           'slug' => 'required|unique:users',
           'email' => 'required|unique:users|email:dns',
            'alamat' => 'required|min:8|max:50',
            'no_hp' => 'required|min:11|max:17',
            'password' => 'required|confirmed|min:8|max:20',
           'role' => 'nullable'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
    
       User::create($validatedData);
       return redirect('/users')->with('success', 'User Baru Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('dashboard.user.edit_user', [
            "title" => "Edit Data User",
            "users" => $user::all(),
            "user" => $user
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules =[
            'nama' => 'required|min:8|max:255',
             'alamat' => 'required|min:8|max:50',
             'no_hp' => 'required|min:11|max:17',
            'role' => 'nullable'
           ];

      if($request->email != $user->email){
        $rules['email'] = 'required|unique:users|email:dns';
      }
      if($request->slug != $user->slug){
        $rules['slug'] = 'required|unique:users';
      }

      $validatedData = $request->validate($rules);

      Penjualan::where('user_id' , $user->id)->update(['pembeli' => $validatedData['nama']]);
       User::where('id', $user->id)->update($validatedData);

       if($request->url == 'users.index'){
        return redirect('/users')->with('success', 'Data User Berhasil Diubah');
       }
       if($request->url == 'pelanggan'){
        return redirect('/users/pelanggan')->with('success', 'Data User Berhasil Diubah');
       }

    
       
       
    
    }


    public function update_profile(Request $request, User $user)
    {
        $rules =[
            'nama' => 'required|min:8|max:255',
             'alamat' => 'required|min:8|max:50',
             'no_hp' => 'required|min:11|max:17',
             'password' => 'nullable|confirmed|min:8|max:20',
           ];

      if($request->email != auth()->user()->email){
        $rules['email'] = 'required|unique:users|email:dns';
       
      }
      if($request->slug != auth()->user()->slug){
        $rules['slug'] = 'required|unique:users';
      }

      $validatedData = $request->validate($rules);

          if($validatedData['password']){
            $validatedData['password'] = Hash::make($validatedData['password']);
          }else{
            $validatedData['password'] = auth()->user()->password;
          }
    
          Penjualan::where('user_id' , auth()->user()->id)->update(['pembeli' => $validatedData['nama']]);
          $tes = User::where('id', auth()->user()->id)->update($validatedData);

           return redirect('/dashboard')->with('success' , 'Profile berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Penjualan::where('user_id' , $user->id)->update(['user_id' => 0]);
        User::destroy($user->id);
        if(session('path') == 'users.index'){
            return redirect('/users')->with('success', 'Data User Berhasil Dihapus');
           }
           if(session('path') == 'pelanggan'){
            return redirect('/users/pelanggan')->with('success', 'Data User Berhasil Dihapus');
           }
    }


    public function pelanggan(User $user, Request $request)
    {
       $users = $user::where('role' , '=' , '3')->latest();
     
        if($request->search){
            $users->where('nama', 'like', '%'. $request->search . '%');
        }
        $path =  session()->put('path', Route::current()->getName());
        return view('dashboard.user.pelanggan_view', [
            "title" => "All Pelanggan",
            "users" => $users->paginate(10)->withQueryString(),
            "path" => $path
        ]);
    }


    


    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(User::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);
    }
}
