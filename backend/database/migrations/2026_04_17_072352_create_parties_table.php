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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('party_type'); // client, vendor, both
            $table->string('code')->unique();
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->enum('tax_type', ['registered', 'unregistered', 'consumer', 'special'])->default('registered');
            $table->enum('payment_terms', ['immediate', 'net_15', 'net_30', 'net_45', 'net_60'])->default('net_30');
            $table->integer('credit_limit')->nullable(); // in cents
            $table->integer('credit_days')->default(30);
            $table->enum('status', ['active', 'inactive', 'blocked', 'pending'])->default('active');
            $table->string('currency', 3)->default('USD');
            $table->json('billing_address')->nullable();
            $table->json('shipping_address')->nullable();
            $table->json('contacts')->nullable();
            $table->json('bank_details')->nullable();
            $table->json('documents')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['party_type', 'status']);
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
