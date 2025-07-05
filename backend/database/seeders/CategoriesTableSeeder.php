<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            $organizationId = DB::table('organizations')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

            DB::table('categories')->insert([
                'uuid' => Str::uuid(),
                'name' => ucfirst($faker->word),
                'description' => $faker->sentence,
                'organization_id' => $organizationId,
                // Add any other relevant product category fields
            ]);
        }
    }
}
