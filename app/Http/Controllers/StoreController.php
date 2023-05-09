<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stores = Store::where('name', 'like', "%{$request->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($stores);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store = new Store;
        $store->name = $validatedData['name'];
        $store->save();

        return response()->json([
            'success' => true,
            'message' => 'Store created successfully',
            'data' => $store
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
        $store = Store::findOrFail($id);
        return response()->json($store);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store = Store::findOrFail($id);
        $store->name = $validatedData['name'];
        $store->save();

        return response()->json([
            'success' => true,
            'message' => 'Store updated successfully',
            'data' => $store
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
        if($store->delete()){
            Product::where('store_id', $id)->delete();
        }
        return response()->json([
            'success' => true,
            'message' => 'Store deleted successfully'
        ], 200);
    }
}
