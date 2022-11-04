<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with('category')->get();
        // $category = Category::all();
        return response()->json([
            'success' => true,
            'product' => $product,
            // 'category' => $category
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

        $validator = Validator::make(request()->all(), [
            'nama_product' => 'required',
            'description' => 'required',
            'harga' => 'required',
            'category_id' => 'required',
            'gambar' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $ekstensi = $request->file('gambar')->getClientOriginalExtension();
        $gambar = $request->file('gambar');
        $gambar->move('image', $request->input('nama_product') . "." . $ekstensi);

        $product = Product::create([
            'nama_product' => $request->nama_product,
            'description' => $request->description,
            'harga' => $request->harga,
            'category_id' => $request->category_id,
            'gambar' => $request->input('nama_product') . "." . $ekstensi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'produk baru telah dibuat',
            'product' => $product

        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category')->find($id);
        return response()->json([
            'success' => true,
            'product' => $product,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $validator = Validator::make(request()->all(), [
        //     'nama_product' => 'required',
        //     'harga' => 'required',
        //     'category_id' => 'required',
        //     'deskripsi' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        $product = Product::find($id);
        if ($request->file('gambar')) {
            $ekstensi = $request->file('gambar')->getClientOriginalExtension();
            $gambar = $request->file('gambar');
            $gambar->move('image', $request->input('nama_product') . "." . $ekstensi);
            $product->gambar = $request->input('nama_product') . "." . $ekstensi;
        }
        $product->nama_product = $request->nama_product;
        $product->description = $request->description;
        $product->harga = $request->harga;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'produk berhasil telah diubah',
            'product' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'produk berhasil di hapus'
        ]);
    }
}
