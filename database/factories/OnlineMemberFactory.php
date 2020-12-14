<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OnlineMember;
use Faker\Generator as Faker;

$factory->define(OnlineMember::class, function (Faker $faker) {
    $id = $faker->unique()->numberBetween($min = 0, $max = 9999);
    return [
        'MEMBER_NO' => $id,
        'PASSWORD' => 'pass' . $id,
        'NAME' => $faker->name(),
        'AGE' => $faker->numberBetween($min = 0, $max = 99),
        'SEX' => $faker->randomElement($array = ['M', 'F']),
        'ZIP' => substr_replace($faker->postcode, '-', 3, 0),
        'ADDRESS' => $faker->address,
        'TEL' => $faker->phoneNumber,
        'REGISTER_DATE' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'DELETE_FLG' => $faker->numberBetween($min = 0, $max = 1),
        'LAST_UPD_DATE' => now()
    ];
});
