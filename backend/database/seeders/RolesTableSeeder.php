<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $roles = [];
        $organizationIds = DB::table('organizations')->pluck('id');

        // Generate roles using Faker
        foreach ($organizationIds as $organizationId) {
            $roles[] = [
                'uuid' => Str::uuid(),
                'name' => ucfirst($faker->unique()->word),
                'organization_id' => $organizationId,
            ];
        }

        DB::table('roles')->insert($roles);
    }
}
