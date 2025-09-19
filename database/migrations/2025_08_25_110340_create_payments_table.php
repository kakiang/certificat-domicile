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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('certificat_id')->nullable()->constrained()->onDelete('set null');
            $table->string('item_name');
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('XOF');
            $table->string('customer_email')->nullable();
            $table->text('custom_field')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('status')->default('pending'); // pending, initiated, success, failed, cancelled, invalid
            $table->text('paytech_response')->nullable();
            $table->text('error_message')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
            
            $table->index('order_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
