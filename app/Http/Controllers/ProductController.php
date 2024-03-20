<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    //untuk membuat form product
    public function create_product() {
        return view('product.create');
    }

    //untuk tempat penyimpanan form product
    public function store_product(Request $request){
        $request->validate([
        'name' => 'required',
        'price' => 'required',
        'stock' => 'required',
        'description' => 'required',
        'image' => 'required',
        ]);

        //untuk image perlu tambahan manipulasi file dicontroller
        $file = $request->file('image');
        $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension(); //untuk merubah nama file gambar
        // akan disimpan dimana file gambarnya
        Storage::disk('local')->put('public/' . $path, file_get_contents($file));


        Product::create([
            'name' =>  $request->name,
            'price' =>   $request->price,
            'stock' =>    $request->stock,
            'description' =>     $request->description,
            'image' =>      $path
        ]);

        return Redirect::route('index');
    }

    public function index(){
        $product= Product::all();

        return view('product.index', compact('product'));
    }

    public function show(Product $product){
        return view('product.detail', compact('product'));
    }

    public function edit(Product $product){
        return view('product.edit', compact('product'));
    }

    public function update(Product $product, Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
    
        //untuk image perlu tambahan manipulasi file dicontroller
        $file = $request->file('image');
        //untuk mengatur nama file gambarnya
        $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension(); //untuk merubah nama file gambar
        // akan disimpan dimana file gambarnya
        Storage::disk('local')->put('public/' . $path, file_get_contents($file));
    
    
        $product->update([
            'name' =>  $request->name,
            'price' =>   $request->price,
            'stock' =>    $request->stock,
            'description' =>     $request->description,
            'image' =>      $path
        ]);
    
        return Redirect::route('show', $product);
    }

    public function delete(Product $product){
        if ($product) {
            unlink("storage/". $product['image']);
            $product->delete();
        }
        else{
            echo "gagal hapus";
        }
        return redirect()->back();
    }
}
