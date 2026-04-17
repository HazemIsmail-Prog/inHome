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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->string('reference_number')->nullable();
            $table->foreignId('vendor_id')->constrained('parties')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->date('order_date');
            $table->date('expected_date');
            $table->date('delivery_date')->nullable();
            $table->enum('status', ['draft', 'sent', 'confirmed', 'partially_received', 'completed', 'cancelled', 'returned'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->integer('subtotal')->default(0); // in cents
            $table->integer('tax_amount')->default(0); // in cents
            $table->integer('discount_amount')->default(0); // in cents
            $table->integer('shipping_cost')->default(0); // in cents
            $table->integer('total_amount')->default(0); // in cents
            $table->string('currency', 3)->default('USD');
            $table->integer('exchange_rate')->default(10000); // in basis points (10000 = 1.0000)
            $table->text('terms_and_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['po_number', 'status']);
            $table->index(['vendor_id', 'status']);
            $table->index('order_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
