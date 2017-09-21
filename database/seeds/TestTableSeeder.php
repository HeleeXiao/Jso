<?php

use Illuminate\Database\Seeder;
use App\Models\Test;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Test::truncate();
        factory(Test::class, 5)->create();
    }
}
