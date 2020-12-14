<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OnlineCategory;
use App\Models\OnlineProduct;
use Faker\Generator as Faker;

$factory->define(OnlineProduct::class, function (Faker $faker) {
    $category = OnlineCategory::inRandomOrder()->first();
    $id = $faker->unique()->numberBetween($min = 0, $max = 9999);
    return [
        'PRODUCT_CODE' => '0' . $faker->unique()->regexify('[A-Za-z0-9]{13}'),
        'CATEGORY_ID' => $category->CTGR_ID,
        'PRODUCT_NAME' => '商品' . $id,
        'MAKER' => $faker->company(),
        'STOCK_COUNT' => $faker->numberBetween($min = 0, $max = 999),
        'REGISTER_DATE' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'UNIT_PRICE' => ($faker->numberBetween($min = 0, $max = 999)) * 10,
        'PICTURE_NAME' => $id % 5 === 0 ? null : '/storage/product/' . str_replace('カテゴリー', 'capital_', $category->NAME) . '.png',
        'MEMO' => $id % 3 === 0 ? null :  $id . 'メモ　めも 目藻mEｍ0.。メモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモメモ',
        'DELETE_FLG' => $faker->numberBetween($min = 0, $max = 1),
        'LAST_UPD_DATE' => now()
    ];
});
