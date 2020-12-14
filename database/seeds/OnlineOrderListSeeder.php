<?php

use App\Models\OnlineOrderList;
use Illuminate\Database\Seeder;

class OnlineOrderListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OnlineOrderList::class, 10)->create();
    }
}
