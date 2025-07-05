<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 100) as $index) {
            $unitId = DB::table('units')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

            $categoryId = DB::table('categories')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

            $organizationId = DB::table('organizations')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();


            DB::table('products')->insert([
                'uuid' => Str::uuid(),
                'name' => ucfirst($faker->word) . ' ' . $faker->word,
                'description' => $faker->sentence,
                'price' => $faker->randomFloat(2, 10, 100),
                'unit_id' => $unitId,
                'category_id' => $categoryId,
                'organization_id' => $organizationId,
                // Add any other relevant product fields
            ]);
        }
    }
}
