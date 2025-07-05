<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\EWalletController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PaymentTermController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\InvoiceSettingController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Create a new tenant user under a new organization
Route::post('/register', [AuthController::class, 'register']);
// Logs in a user
Route::post('/login', [AuthController::class, 'login']);

// Forgot Password Routes
Route::post('/password/send-reset-link', [ResetPasswordController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [ResetPasswordController::class, 'resetPassword']);


// Account Verification Routes
Route::get('/email/verify/{token}', [VerificationController::class, 'verify'])
    ->where('token', '^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[1-5][0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$')
    ->name('verification.verify');

// Accessible only to authenticated users
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Account Verification Routes
    Route::get('/email/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Returns the currently authenticated user
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    // Logout the currently authenticated user
    Route::post('/logout',   [AuthController::class, 'logout']);

    // Accesssible only to users in the organization and to verified users
    Route::prefix('organizations/{orgUuid}')->middleware([
        'user.in.organization', 'email.verified'
    ])->group(function () {

        Route::post('/upload-photo', [OrganizationController::class, 'uploadPhoto']);
        Route::delete('/delete-photo', [OrganizationController::class, 'deletePhoto']);

        // Products endpoints
        Route::post('/products/{uuid}/upload-photo', [ProductController::class, 'uploadPhoto'])
            ->middleware('belongs.to.organization:Product');

        Route::delete('/products/{uuid}/delete-photo', [ProductController::class, 'deletePhoto'])
            ->middleware('belongs.to.organization:Product');

        Route::apiResource('/products', ProductController::class)->parameters([
            'products' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Product');

        // Categories endpoints
        Route::apiResource('/categories', CategoryController::class)->parameters([
            'categories' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Category');

        // Units endpoints
        Route::apiResource('/units', UnitController::class)->parameters([
            'units' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Unit');

        // Customers endpoints
        Route::post('/customers/{uuid}/upload-photo', [CustomerController::class, 'uploadPhoto'])
            ->middleware('belongs.to.organization:Customer');

        Route::delete('/customers/{uuid}/delete-photo', [CustomerController::class, 'deletePhoto'])
            ->middleware('belongs.to.organization:Customer');

        Route::apiResource('/customers', CustomerController::class)->parameters([
            'customers' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Customer');

        // Invoices endpoints
        Route::put('/invoices/{uuid}/update-setting', [InvoiceSettingController::class, 'update'])
            ->middleware('belongs.to.organization:Invoice');
        Route::apiResource('/invoices', InvoiceController::class)->parameters([
            'invoices' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Invoice');

        // Payment Terms endpoints
        Route::apiResource('/payment-terms', PaymentTermController::class)->parameters([
            'payment-terms' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:PaymentTerm');

        // Purchases endpoints
        Route::apiResource('/purchases', PurchaseController::class)->parameters([
            'purchases' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Purchase');

        // Supplier endpoints
        Route::apiResource('/suppliers', SupplierController::class)->parameters([
            'suppliers' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Supplier');

        // Bank\ endpoints
        Route::apiResource('/banks', BankController::class)->parameters([
            'banks' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Bank');

        // E Wallet endpoints
        Route::apiResource('/e-wallets', EWalletController::class)->parameters([
            'e-wallets' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:EWallet');

         // Payment endpoints
         Route::apiResource('/payments', PaymentController::class)->parameters([
            'payments' => 'uuid', // Change the route parameter name since we change the model binding to 'uuid'
        ])->middleware('belongs.to.organization:Payment');
    });
});
