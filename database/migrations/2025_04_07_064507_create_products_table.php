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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('product_code')->nullable();
            $table->string('thumbnail_image', 255)->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();
            $table->enum('is_featured', ['Yes', 'No'])->default('No')->nullable();
            $table->enum('is_top_selling', ['Yes', 'No'])->default('No')->nullable();
            $table->enum('is_popular', ['Yes', 'No'])->default('No')->nullable();
            $table->enum('is_special', ['Yes', 'No'])->default('No')->nullable();
            $table->enum('is_best', ['Yes', 'No'])->default('No')->nullable();
            $table->enum('is_new', ['Yes', 'No'])->default('No')->nullable();
            $table->ipAddress('ip_address');
            $table->enum('status', ['a', 'd'])->default('a')->comment('a=active, d=deactive,');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
