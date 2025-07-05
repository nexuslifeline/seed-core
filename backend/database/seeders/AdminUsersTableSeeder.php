<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // admin users
        foreach (range(1, 15) as $index) {
            $userId = DB::table('users')->insertGetId([
                'uuid' => Str::uuid(),
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('123456'), // You may customize the password
                'type' => 'admin',
            ]);

            DB::table('contacts')->insert([
                'user_id' => $userId,
                'phone_no' => $faker->phoneNumber,
                'mobile_no' => $faker->phoneNumber,
                'address' => $faker->address,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip_code' => $faker->postcode,
                'facebook' => $faker->url,
                'twitter' => $faker->url,
                'linkedin' => $faker->url,
                'website' => $faker->url
            ]);
        }
    }
}
