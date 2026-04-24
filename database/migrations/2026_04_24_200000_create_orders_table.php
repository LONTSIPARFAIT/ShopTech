<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            $table->string('payment_method')->nullable(); // notchpay, cod
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, failed
            $table->string('payment_id')->nullable(); // Notch Pay transaction ID
            $table->text('shipping_address')->nullable();
            $table->string('customer_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
