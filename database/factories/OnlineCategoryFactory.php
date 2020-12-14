<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OnlineCategory;
use Faker\Generator as Faker;

$factory->define(OnlineCategory::class, function (Faker $faker) {
    return [
        'CTGR_ID' => $faker->unique()->numberBetween($min = 0, $max = 9999),
        'NAME' => 'カテゴリー' . $faker->unique()->randomLetter(),
        'LAST_UPD_DATE' => now()
    ];
});
