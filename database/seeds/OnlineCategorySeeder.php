<?php

use App\Models\OnlineCategory;
use Illuminate\Database\Seeder;

class OnlineCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OnlineCategory::class, 26)->create();
    }
}
