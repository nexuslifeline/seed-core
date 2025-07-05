<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            // Foreign key relationships
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->enum('discount_type', ['flat', 'percentage'])->default('flat');
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0.00);
            $table->decimal('discount_rate', 10, 2)->nullable()->default(0.00);

            $table->integer('quantity')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable()->default(0.00);
            $table->decimal('tax_total', 10, 2)->nullable()->default(0.00);
            $table->decimal('line_total', 10, 2)->nullable()->default(0.00);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
