<?php

namespace App\Http\Controllers;

use App\Models\Category;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return response()->json([
            'success' => true,
            'category' => $category
        ], 200);
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
            'nama_category' => 'required|unique:categories'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create([
            'nama_category' => $request->nama_category
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori Baru Telah ditambahkan',
            'category' => $category
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'nama_category' => 'required|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::find($id);
        $category->nama_category = $request->nama_category;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'kategori berhasil telah diubah',
            'category' => $category
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'kategori berhasil di hapus'
        ]);
    }
}
