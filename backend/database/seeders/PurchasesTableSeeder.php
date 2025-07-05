<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            $purchaseDate = $faker->date;


            $paymentTermId = DB::table('payment_terms')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

            $supplier = DB::table('suppliers')
                ->inRandomOrder()
                ->select('id', 'organization_id')
                ->first();

            $purchaseId = DB::table('purchases')->insertGetId([
                'uuid' => Str::uuid(),
                'purchase_no' => $faker->unique()->randomNumber(6),
                'supplier_id' => $supplier->id,
                'organization_id' => $supplier->organization_id,
                'purchase_date' => $purchaseDate,
                'total_amount' => $faker->randomFloat(2, 50, 500),
                'payment_term_id' => $paymentTermId
            ]);


            foreach (range(1, 20) as $index) {
                $productId = DB::table('products')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

                DB::table('purchase_items')->insert([
                    'purchase_id' => $purchaseId,
                    'product_id' => $productId,
                    'quantity' => $faker->randomNumber(2),
                    'unit_price' => $faker->randomFloat(2, 10, 100),
                    // Add any other relevant invoice item fields
                ]);
            }
        }
    }
}
