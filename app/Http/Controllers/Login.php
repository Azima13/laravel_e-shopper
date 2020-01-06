<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    //
    public function index()
    {
      return view('Login');
    }
    public function Register(Request $request)
    {
      // code...
      DB::table('tbl_user')->insert([
        'nama_user' => $request->nama,
        'email' => $request->email,
        'password' => $request->password
      ]);
      return redirect('/Login');
    }
    public function Masuk(Request $request)
    {
      // code...
      $user = DB::table('tbl_user')->where('email',$request->email)->first();
      if ($user->password == $request->password) {
        // code...
        // $request->Session()->put('id',$user->id);
        session::put('id_user', $user->id);
        echo "Data disimpan dengan session id =".$request->session()->get('id');
        return redirect('/');
      }else {
        // code...
        echo "Anda gagal login";
      }
    }
    public function Keluar()
    {
      // code...
      Session::forget('id_user');
      return redirect('/');
    }
}
