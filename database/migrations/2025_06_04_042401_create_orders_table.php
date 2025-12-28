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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('zip_code');
            $table->string('delivery_zone')->nullable();
            $table->string('payment_method');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('coupon_code')->nullable();
            $table->decimal('total', 10, 2);
            $table->string('tracking_number')->nullable();
            $table->string('shipping_carrier')->nullable();
            $table->enum('status', ['a', 'd', 'p', 'c'])->default('p')->comment('a=approved, d=declined, p=pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
