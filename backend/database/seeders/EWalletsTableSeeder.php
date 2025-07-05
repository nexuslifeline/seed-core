<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EWalletsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            // Define e wallets data
            $eWallets = [
                ['uuid' => Str::uuid(), 'name' => 'GCash', 'organization_id' => $i],
                ['uuid' => Str::uuid(), 'name' => 'Paymaya', 'organization_id' => $i],
                ['uuid' => Str::uuid(), 'name' => 'Paypal', 'organization_id' => $i],
            ];

            // Insert data into the payment_terms table
            DB::table('e_wallets')->insert($eWallets);
        }
    }
}
