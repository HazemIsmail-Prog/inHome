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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();
            $table->morphs('reference'); // polymorphic: purchase_orders, sales_orders, stock_transfers, adjustments
            $table->enum('movement_type', ['in', 'out', 'adjustment_in', 'adjustment_out', 'transfer_in', 'transfer_out']);
            $table->enum('transaction_type', ['purchase', 'sale', 'return', 'adjustment', 'transfer', 'opening_stock', 'production']);
            $table->integer('quantity'); // in base unit, 3 decimal places handled by multiplying by 1000
            $table->integer('quantity_before');
            $table->integer('quantity_after');
            $table->integer('unit_cost')->nullable(); // in cents
            $table->integer('total_cost')->nullable(); // in cents
            $table->string('batch_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('reason')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['warehouse_id', 'product_id']);
            $table->index(['movement_type', 'transaction_type']);
            $table->index('batch_number');
            $table->index('serial_number');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
