<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add_to_cart(Product $product, Request $request){
        $user_id = Auth::id();
        $product_id = $product->id;

        $existing_cart = Cart::where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->first();

        if($existing_cart == null ){  //menjalankan jika cart masih kosong
            $request->validate([
                //gte:1 adalah saat add to cart minimal adalah 1 tidak bisa 0
                //lte:' . $cart->product->stock adalah saat add to cart maxsimal setara dengan stock yang ada jika lebih maka error
                'amount' => 'required|gte:1|lte:' . $product->stock
            ]);

            Cart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'amount' => $request->amount,
            ]);

        } else { //jika sudah ada maka akan tinggal update saja di cart yang sudah ada
            $request->validate([
                'amount' => 'required|gte:1|lte:' . ($product->stock - $existing_cart->amount )
            ]);

            $existing_cart->update([
                'amount' => $existing_cart->amount + $request->amount
            ]);
        }

        return Redirect::route('show_cart');
    }

    public function show_cart(){
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();
        return view('product.cart.detail', compact('carts'));
    }

    public function update_cart(Cart $cart, Request $request){
        $request->validate([
            //gte:1 adalah saat add to cart minimal adalah 1 tidak bisa 0
            //lte:' . $cart->product->stock adalah saat add to cart maxsimal setara dengan stock yang ada jika lebih maka error
            'amount' => 'required|gte:1|lte:' . $cart->product->stock
        ]);

        $cart->update([
            'amount' =>  $request->amount
        ]);

        return Redirect('cart');
    }

    public function delete_cart(Cart $cart){
        $cart->delete();
        session()->flash('success','Item berhasil dihapus dari keranjang!');
        return redirect('/cart/');

    }
}
