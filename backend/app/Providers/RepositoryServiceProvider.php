<?php

namespace App\Providers;

use App\Repositories\BankRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SupplierRepository;
use App\Repositories\InvoiceItemRepository;
use App\Repositories\PaymentTermRepository;
use App\Repositories\OrganizationRepository;
use App\Repositories\PurchaseItemRepository;
use App\Repositories\BankRepositoryInterface;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\UnitRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\InvoiceSettingRepository;
use App\Repositories\EWalletRepositoryInterface;
use App\Repositories\InvoiceRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\EWalletRepository;
use App\Repositories\PurchaseRepositoryInterface;
use App\Repositories\SupplierRepositoryInterface;
use App\Repositories\InvoiceItemRepositoryInterface;
use App\Repositories\PaymentTermRepositoryInterface;
use App\Repositories\OrganizationRepositoryInterface;
use App\Repositories\PurchaseItemRepositoryInterface;
use App\Repositories\InvoiceSettingRepositoryInterface;
use App\Repositories\PaymentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(InvoiceItemRepositoryInterface::class, InvoiceItemRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(InvoiceSettingRepositoryInterface::class, InvoiceSettingRepository::class);
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PaymentTermRepositoryInterface::class, PaymentTermRepository::class);
        $this->app->bind(SupplierRepositoryInterface:: class, SupplierRepository::class);
        $this->app->bind(PurchaseRepositoryInterface:: class, PurchaseRepository::class);
        $this->app->bind(PurchaseItemRepositoryInterface:: class, PurchaseItemRepository::class);
        $this->app->bind(BankRepositoryInterface:: class, BankRepository::class);
        $this->app->bind(EWalletRepositoryInterface:: class, EWalletRepository::class);
        $this->app->bind(PaymentRepositoryInterface:: class, PaymentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
