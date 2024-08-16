<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Hash;
use DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 individual users
        $faker = \Faker\Factory::create();
        $now = Carbon::now();
        for ($i = 0; $i < 10; $i++) {

            DB::table("users")->insert([
                "name" => $faker->name,
                "email" => $faker->unique()->safeEmail,
                "password" => Hash::make("password"),
                'user_type' => 'individual',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Create 1 admin user
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

    }
}
