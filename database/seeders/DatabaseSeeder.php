<?php

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\Employee;
use App\Models\Laundry;
use App\Models\Parfume;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UserSeeder::class);
    }
}
