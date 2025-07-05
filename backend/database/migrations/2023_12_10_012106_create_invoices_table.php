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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->index();
            $table->string('invoice_no')->nullable();

            // Foreign key relationship with the customers table
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');

            $table->unsignedBigInteger('payment_term_id');
            $table->foreign('payment_term_id')->references('id')->on('payment_terms')->onDelete('cascade');

            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('discount_type', ['flat', 'percentage'])->default('flat');
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0.00);
            $table->decimal('discount_rate', 10, 2)->nullable()->default(0.00);

            $table->decimal('tax_total', 10, 2)->nullable()->default(0.00);

            $table->decimal('total_amount', 10, 2)->nullable()->default(0.00);
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue'])->default('draft');
            $table->text('bill_to')->nullable();
            $table->text('bill_from')->nullable();
            $table->text('ship_to')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
