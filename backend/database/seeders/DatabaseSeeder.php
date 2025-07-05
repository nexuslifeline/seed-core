<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(OrganizationsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $this->call(OrgUsersTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PaymentTermsTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);

    }
}
