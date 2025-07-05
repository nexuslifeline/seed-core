<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {

            $organizationId = DB::table('organizations')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

            DB::table('suppliers')->insert([
                'name' => $faker->name,
                'uuid' => Str::uuid(),
                'phone_no' => $faker->phoneNumber,
                'mobile_no' => $faker->phoneNumber,
                'address' => $faker->address,
                'website' => $faker->url,
                'fax' => $faker->numerify('###-###-####'),
                'email' => $faker->email,
                'organization_id' => $organizationId
                // Add any other relevant supplier fields
            ]);
        }
    }
}
