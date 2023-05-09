<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $store = new Store();
        $store->name = 'My Store';
        $store->save();

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->name = 'Product ' . $i;
            $product->store_id = $store->id;
            $product->save();
        }
    }
}
