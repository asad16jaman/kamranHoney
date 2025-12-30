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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('title', 255)->nullable();
            $table->text('review')->nullable();
            $table->string('image')->nullable();
            $table->ipAddress('ip_address');
            $table->enum('status', ['a', 'd'])->default('a')->comment('a=active, d=deactive,');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
