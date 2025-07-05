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
        Schema::create('invoice_settings', function (Blueprint $table) {
            $table->id();
            // Foreign key relationships
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->enum('due_reminder', ['on_due_date', 'before_7_days', 'before_15_days'])->default('before_7_days');
            $table->enum('late_fee_type', ['flat', 'percentage'])->default('percentage');
            $table->decimal('late_fee_rate', 10, 2)->nullable()->default(0);
            $table->decimal('late_fee', 10, 2)->nullable()->default(0);
            $table->boolean('is_gst_enabled')->default(false); // Goods and Service Tax
            $table->boolean('is_unit_enabled')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->boolean('custom_fields_enabled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_settings');
    }
};
