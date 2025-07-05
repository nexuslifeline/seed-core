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
        Schema::create('puchase_item_taxes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tax_type_id');
            $table->foreign('tax_type_id')->references('id')->on('tax_types')->onDelete('cascade');
            $table->decimal('tax_rate', 10, 2)->nullable()->default(0.00);
            $table->decimal('tax_amount', 10, 2)->nullable()->default(0.00);

            $table->unsignedBigInteger('purchase_item_id');
            $table->foreign('purchase_item_id')->references('id')->on('purchase_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puchase_item_taxes');
    }
};
