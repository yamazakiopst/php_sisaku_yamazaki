<?php

use App\Models\OnlineProduct;
use Illuminate\Database\Seeder;

class OnlineProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OnlineProduct::class, 100)->create();
    }
}
