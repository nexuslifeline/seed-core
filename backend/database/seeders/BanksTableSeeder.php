<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $index) {
            $organizationId = DB::table('organizations')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();


            DB::table('banks')->insert([
                'uuid' => Str::uuid(),
                'name' => ucfirst($faker->company()) . ' Bank',
                'organization_id' => $organizationId
            ]);
        }
    }
}
