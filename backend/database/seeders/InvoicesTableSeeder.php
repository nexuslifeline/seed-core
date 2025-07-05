<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class InvoicesTableSeeder extends Seeder
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
            $invoiceDate = $faker->date;


            $paymentTermId = DB::table('payment_terms')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

            $customer = DB::table('customers')
                ->inRandomOrder()
                ->select('id', 'organization_id')
                ->first();

            $invoiceId = DB::table('invoices')->insertGetId([
                'uuid' => Str::uuid(),
                'invoice_no' => $faker->unique()->randomNumber(6),
                'customer_id' => $customer->id,
                'organization_id' => $customer->organization_id,
                'issue_date' => $invoiceDate,
                'due_date' => date('Y-m-d', strtotime($invoiceDate . ' +30 days')),
                'total_amount' => $faker->randomFloat(2, 50, 500),
                'payment_term_id' => $paymentTermId
            ]);


            foreach (range(1, 20) as $index) {
                $productId = DB::table('products')
                    ->inRandomOrder()
                    ->pluck('id')
                    ->first();

                DB::table('invoice_items')->insert([
                    'invoice_id' => $invoiceId,
                    'product_id' => $productId,
                    'quantity' => $faker->randomNumber(2),
                    'unit_price' => $faker->randomFloat(2, 10, 100),
                    // Add any other relevant invoice item fields
                ]);
            }
        }
    }
}
