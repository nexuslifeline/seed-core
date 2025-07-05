<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            // Define payment terms data
            $paymentTerms = [
                ['uuid' => Str::uuid(), 'name' => 'Net 7', 'description' => 'Payment due in 7 days', 'organization_id' => $i],
                ['uuid' => Str::uuid(), 'name' => 'Net 21', 'description' => 'Payment due in 21 days', 'organization_id' => $i],
                ['uuid' => Str::uuid(), 'name' => 'Net 30', 'description' => 'Payment due in 30 days', 'organization_id' => $i],
                ['uuid' => Str::uuid(), 'name' => 'Immediate', 'description' => 'Immediate payment required', 'organization_id' => $i],
                ['uuid' => Str::uuid(), 'name' => 'On Delivery', 'description' => 'Payment due on delivery', 'organization_id' => $i],
                // Add more payment terms as needed
            ];

            // Insert data into the payment_terms table
            DB::table('payment_terms')->insert($paymentTerms);
        }
    }
}
