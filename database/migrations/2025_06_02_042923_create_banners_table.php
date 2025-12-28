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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable();
            $table->string('title_one', 255)->nullable();
            $table->string('title_two', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->float('discount')->nullable();
            $table->string('button_text', 100)->nullable();
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
        Schema::dropIfExists('banners');
    }
};
