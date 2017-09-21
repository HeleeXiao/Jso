<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::truncate();
        factory(Customer::class, 5)->create();
    }
}
