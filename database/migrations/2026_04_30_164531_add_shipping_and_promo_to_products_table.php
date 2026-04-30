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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('base_price');
            $table->integer('promo_min_quantity')->nullable()->after('original_price');
            $table->integer('promo_discount_percent')->nullable()->after('promo_min_quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['shipping_cost', 'promo_min_quantity', 'promo_discount_percent']);
        });
    }
};
