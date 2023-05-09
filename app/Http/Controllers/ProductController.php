<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $storeId)
    {
        try {
            $product =  Product::where('name', 'like', "%{$request->search}%")
                ->where('store_id', $storeId)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return $this->returnResult([
                "error" => 0,
                "data" => $product,
            ]);
        } catch (\Exception $e) {
            return $this->responseJson(CODE_ERROR, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $storeId)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $store = Store::findOrFail($storeId);

            $product = new Product;
            $product->name = $validatedData['name'];
            $product->store_id = $storeId;
            $product->save();

            return $this->returnResult([
                "error" => 0,
                "data" => $product,
            ]);
        } catch (\Exception $e) {
            return $this->responseJson(CODE_ERROR, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($storeId, $id)
    {
        try {
            $store = Store::findOrFail($storeId);
            $product = $store->products()->findOrFail($id);
            return $this->returnResult([
                "error" => 0,
                "data" => $product,
            ]);
        } catch (\Exception $e) {
            return $this->responseJson(CODE_ERROR, $e->getMessage());
        }
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
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);
            $store = Store::findOrFail($storeId);
            $product = $store->products()->findOrFail($productId);

            $product->name = $validatedData['name'];
            $product->save();

            return $this->returnResult([
                "error" => 0,
                "data" => $product,
            ]);
        } catch (\Exception $e) {
            return $this->responseJson(CODE_ERROR, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($storeId, $id)
    {
        try {
            $store = Store::findOrFail($storeId);
            $product = $store->products()->findOrFail($id);
            $product->delete();

            return $this->returnResult([
                "error" => 0,
                "data" => $product,
            ]);
        } catch (\Exception $e) {
            return $this->responseJson(CODE_ERROR, $e->getMessage());
        }
    }
}
