<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function email(Request $request ,User $user)
    {
        $request->session()->forget('alert');

        $data = [
            'subject' => 'Restok Barang',
            'body' => 'Email ini dibuat untuk memberitahu anda bahwa kami telah melakukan Restok untuk produk',
            'supplier' => Supplier::where('id' , session('data_barang')[1])->pluck('nama_supplier'),
            'waktu' => 'Pagi'
        ];
      
        try{

            //mengirim email ke multiple email/penerima
            $user::chunk(10, function($users) use ($data) {
                $penerima = $users->pluck('email');
                $timer = Carbon::now()->format('H');
                if($timer > 00 && $timer <= 11){
                    $data['waktu'] = "Pagi";
                }
                if($timer > 11 && $timer <= 15){
                    $data['waktu'] = "Siang";
                }
                if($timer > 15 && $timer <= 18){
                    $data['waktu'] = "Sore";
                }
                if($timer > 18 && $timer <= 00){
                    $data['waktu'] = "Malam";
                }

                Mail::bcc($penerima)->send(new MailNotify($data));
      
            });
            return back();
         
            
        }catch(Exception $th){
            return response()->json([$th->getMessage()]);
        }

    }
}
