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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100)->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone', 20)->nullable();
            $table->string('hotline', 20)->nullable();
            $table->string('company_slogan', 100)->nullable();
            $table->string('company_email', 100)->unique()->nullable();

            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->integer('inside')->nullable();
            $table->integer('outside')->nullable();

            $table->string('favicon_image')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('footer_title')->nullable();
            $table->text('footer_short_description')->nullable();
            $table->text('footer_description')->nullable();

            $table->text('company_about')->nullable();
            $table->text('google_map')->nullable();
            $table->text('office_hour')->nullable();

            $table->text('copyright')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
