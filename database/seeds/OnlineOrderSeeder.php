<?php

use App\Models\OnlineOrder;
use Illuminate\Database\Seeder;

class OnlineOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OnlineOrder::class, 10)->create();
    }
}
