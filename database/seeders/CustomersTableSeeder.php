<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customer::create([
            'name' => 'Muhammad Jamil',
            'username' => 'mdjamilaj',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
