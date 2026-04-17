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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('so_number')->unique();
            $table->string('reference_number')->nullable();
            $table->foreignId('client_id')->constrained('parties')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->date('order_date');
            $table->date('required_date');
            $table->date('shipped_date')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'processing', 'shipped', 'delivered', 'partially_delivered', 'cancelled', 'returned'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('payment_status', ['pending', 'partially_paid', 'paid', 'overdue'])->default('pending');
            $table->integer('subtotal')->default(0); // in cents
            $table->integer('tax_amount')->default(0); // in cents
            $table->integer('discount_amount')->default(0); // in cents
            $table->integer('shipping_cost')->default(0); // in cents
            $table->integer('total_amount')->default(0); // in cents
            $table->integer('amount_paid')->default(0); // in cents
            $table->string('currency', 3)->default('USD');
            $table->integer('exchange_rate')->default(10000); // in basis points
            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['so_number', 'status']);
            $table->index(['client_id', 'status']);
            $table->index(['payment_status', 'order_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
