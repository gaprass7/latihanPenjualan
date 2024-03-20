<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function checkout(){
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();

        if($carts == null){
            return redirect()->back();
        }

        $order = Order::create([
            'user_id' => $user_id
        ]);

        foreach ($carts as $cart) {
            $product = Product::find($cart->product_id);

            $product->update([
                'stock' => $product->stock - $cart->amount,
            ]);

            Transaction::create([
                'amount' => $cart->amount,
                'order_id' => $order->id,
                'product_id' => $cart->product_id
            ]);

            //untuk delete cart setelah dicheckout
            $cart->delete();
        }

        return Redirect::route('detail', $order);
    }

    public function index(){
        // membuat validasi order agar ditampilan order hanya menampilkan order dari usernya sendiri
        $user = Auth::user();
        $is_admin = $user->is_admin;
        if($is_admin){
            //dapat melihat semua order
            $order = Order::all();
        } else {
            //mem filter order berdasarkan usernya sendiri
            $order = Order::where('user_id', $user->id)->get();
        }
        return view('product.order.index', compact('order'));
    }

    public function detail(Order $order){
        // membuat validasi order agar tidak bisa ke halaman order detail user lain
        $user = Auth::user();
        $is_admin = $user->is_admin;
        if($is_admin || $order->user_id == $user->id )
        {
            return view('product.order.detail', compact('order'));
        } else {
            // jika memaksa ingin ke order user lain maka akan keredirect di order
            return Redirect::route('index');
        }
    }

    public function submit_payment(Order $order, Request $request){
        $file = $request->file('payment_receipt');
        //untuk mengatur nama file gambarnya
        $path = time() . '_' . $order->id . '.' . $file->getClientOriginalExtension(); //untuk merubah nama file gambar
        // akan disimpan dimana file gambarnya
        Storage::disk('local')->put('public/' . $path, file_get_contents($file));

        //untuk cek data
        // dd($path)

        $order->update([
            'payment_receipt' => $path
        ]);

        return Redirect::back();
    }

    public function confirm_payment(Order $order){
        $order->update([
            'is_paid' => true
        ]);

        return Redirect::back();
    }
}
