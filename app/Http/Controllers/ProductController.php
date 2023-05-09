<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $product =  Product::where('name', 'like', "%{$request->search}%")
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $storeId)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store = Store::findOrFail($storeId);
        if($store == null){
            return response()->json([
                'success' => false,
                'message' => 'Store not found',
                'data' => []
            ], 400);
        }

        $product = new Product;
        $product->name = $validatedData['name'];
        $product->store_id = $storeId;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $storeId, $productId)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store = Store::findOrFail($storeId);
        $product = $store->products()->findOrFail($productId);

        $product->name = $validatedData['name'];
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $product = $store->products()->findOrFail($id);

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ], 200);
    }
}
