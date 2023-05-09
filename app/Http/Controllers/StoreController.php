<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use Auth;

class StoreController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $stores = Store::where('name', 'like', "%{$request->search}%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return $this->returnResult([
                "error" => 0,
                "data" => $stores,
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
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $store = new Store;
            $store->name = $validatedData['name'];
            $store->created_by = Auth::id();
            $store->save();

            return $this->returnResult([
                "error" => 0,
                "data" => $store,
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
    public function show($id)
    {
        try {
            $store = Store::findOrFail($id);
            return $this->returnResult([
                "error" => 0,
                "data" => $store,
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
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $store = Store::findOrFail($id);
            $store->name = $validatedData['name'];
            $store->save();

            return $this->returnResult([
                "error" => 0,
                "data" => $store,
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
    public function destroy($id)
    {
        try {
            $store = Store::findOrFail($id);
            if ($store->delete()) {
                Product::where('store_id', $id)->delete();
            }
            return $this->returnResult([
                "error" => 0,
                "data" => $store,
            ]);
        } catch (\Exception $e) {
            return $this->responseJson(CODE_ERROR, $e->getMessage());
        }
    }
}
