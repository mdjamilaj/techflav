<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([PermissionTableSeeder::class]);
        $this->call([UsersTableSeeder::class]);
        $this->call([CustomersTableSeeder::class]);
        $this->call([CountriesTableSeeder::class]);
        $this->call([StatesTableSeeder::class]);
    }
}
