<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Order extends Controller
{
    //
    public function Order(Request $request)
    {
      // code...
      DB::table('tbl_keranjang')->insert([
        'id_user' => session::get('id_user'),
        'id_barang' => $request->id_barang,
        'jumlah' => $request ->jumlah
      ]);
      return redirect('/');
    }
    public function Keranjang()
    {
      // code...
      $Keranjang = DB::table('keranjang')->get();
      return view('Keranjang', ['Keranjang' => $Keranjang]);
    }
    public function Checkout()
    {
      // code...
      $id_check = rand().rand();
      $total = 0;
      $data = DB::table('tbl_keranjang')->where('id_user', Session::get('id_user'))->get();
      foreach ($data as $krj) {
      $barang = DB::table('tbl_barang')->where('id', $krj->id_barang)->get();
      foreach ($barang as $brg) {
        // code...
        $total += ($krj->jumlah * $brg->harga);
        DB::table('detail_checkout')->insert([
          'id_checkout' =>$id_check,
          'id_barang' => $krj->id_barang,
          'jumlah' => $krj->jumlah
        ]);
      }
    }
    DB::table('tbl_checkout')->insert([
      'id_checkout' => $id_check,
      'id_user' => Session::get('id_user'),
      'total' => $total
    ]);
  }
}
