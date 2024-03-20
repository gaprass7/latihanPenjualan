<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect::route('index');
});
// Route::get('product/create', function () {
//     return view('product.create');
// });  

Auth::routes();

//Product Routes
Route::get('product', [ProductController::class, 'index'])->name('index');

Route::middleware(['admin'])->group(function(){
    //product
    Route::get('product/create', [ProductController::class, 'create_product'])->name('create');
    Route::post('product/create', [ProductController::class, 'store_product'])->name('store_product');
    Route::get('product/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::patch('product/{product}/update', [ProductController::class, 'update'])->name('update');
    Route::delete('/product/{product}', [ProductController::class, 'delete'])->name('delete');
    
    //order
    Route::post('order/{order}/confirm', [OrderController::class, 'confirm_payment'])->name('confirm_payment');
});

Route::middleware(['auth'])->group(function(){
    //Product Routes
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('show');
    
    //Cart Routes
    Route::post('cart/{product}', [CartController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('cart', [CartController::class, 'show_cart'])->name('show_cart');
    Route::patch('cart/{cart}', [CartController::class, 'update_cart'])->name('update_cart');
    Route::delete('cart/{cart}', [CartController::class, 'delete_cart'])->name('delete_cart');
    
    //Order Routes
    Route::post('checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('order', [OrderController::class, 'index'])->name('index_order');
    Route::get('order/{order}', [OrderController::class, 'detail'])->name('detail');
    Route::post('order/{order}/pay', [OrderController::class, 'submit_payment'])->name('submit_payment');
    
    //Profile Routes
    Route::get('profile', [ProfileController::class, 'show_profile'])->name('show_profile');
    Route::post('profile', [ProfileController::class, 'edit_profile'])->name('edit_profile');
    
});
