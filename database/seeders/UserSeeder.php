<?php

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\Employee;
use App\Models\Laundry;
use App\Models\Parfume;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password'),
                'role' => User::ROLE_ADMIN,
                'no_hp' => '082246106612'
            ]
        );


    }
}
