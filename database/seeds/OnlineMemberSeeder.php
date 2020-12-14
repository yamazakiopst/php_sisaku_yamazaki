<?php

use App\Models\OnlineMember;
use Illuminate\Database\Seeder;

class OnlineMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OnlineMember::class, 10)->create();
    }
}
