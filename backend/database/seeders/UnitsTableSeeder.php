<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $index) {
            $organizationId = DB::table('organizations')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();


            DB::table('units')->insert([
                'uuid' => Str::uuid(),
                'name' => ucfirst($faker->word),
                'organization_id' => $organizationId,
                'description' => $faker->sentence,
                'abbreviation' => $faker->lexify('??'), // Generates two random letters
            ]);
        }
    }
}
