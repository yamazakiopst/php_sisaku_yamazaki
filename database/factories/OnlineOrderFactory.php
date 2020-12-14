<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OnlineMember;
use App\Models\OnlineOrder;
use Faker\Generator as Faker;

$factory->define(OnlineOrder::class, function (Faker $faker) {
    $id = $faker->unique()->numberBetween($min = 0, $max = 9999);
    $price = ($faker->numberBetween($min = 0, $max = 999)) * 10;
    return [
        'ORDER_NO' => $id,
        'MEMBER_NO' => OnlineMember::inRandomOrder()->first()->MEMBER_NO,
        'TOTAL_MONEY' => $price,
        'TOTAL_TAX' => $price / 10,
        'ORDER_DATE' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'COLLECT_NO' => '0' . $faker->unique()->regexify('[A-Za-z0-9]{15}'),
        'LAST_UPD_DATE' => now()
    ];
});
