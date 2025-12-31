<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('title_1')->nullable();
            $table->string('title_2')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('video_url')->nullable();
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
        Schema::dropIfExists('galleries');
    }
};
