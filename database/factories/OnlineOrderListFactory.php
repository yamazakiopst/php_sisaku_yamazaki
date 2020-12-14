<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OnlineOrder;
use App\Models\OnlineOrderList;
use App\Models\OnlineProduct;
use Faker\Generator as Faker;

$factory->define(OnlineOrderList::class, function (Faker $faker) {
    $product = OnlineProduct::inRandomOrder()->first();
    $count = $faker->numberBetween($min = 1, $max = 10);
    return [
        'LIST_NO' => $faker->unique()->numberBetween($min = 0, $max = 9999),
        'COLLECT_NO' => OnlineOrder::inRandomOrder()->first()->COLLECT_NO,
        'PRODUCT_CODE' => $product->PRODUCT_CODE,
        'ORDER_COUNT' => $count,
        'ORDER_PRICE' => $product->UNIT_PRICE * $count,
    ];
});
