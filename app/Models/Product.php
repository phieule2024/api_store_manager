<?php

namespace App\Models;
use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'store_id',
        'status'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function generateFakeData()
    {
        $faker = Faker::create();

        return [
            'name' => $faker->name,
            'store_id' => 1
        ];
    }
}
