<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'role' => 'admin',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('1234'),
        ]);
        $faker = \Faker\Factory::create();


        for($i = 0 ; $i < 200 ; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password')
            ]);
        }

        for($i = 0 ; $i < 10 ; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'role' => 'admin',
                'password' => Hash::make('password')
            ]);
        }
        
    }
}
