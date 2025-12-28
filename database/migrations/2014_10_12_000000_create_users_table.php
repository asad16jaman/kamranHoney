<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('type', 20);
            $table->string('username')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->ipAddress('ip_address');
            $table->enum('status', ['a', 'p', 'd'])->default('a')->comment('a=active, p=pending, d=deactive');
            $table->rememberToken();
            $table->timestamps();
        });

        // create default one
        $user = new User();
        $user->name = 'Mr. Admin';
        $user->email = 'admin@mail.com';
        $user->type = 'admin';
        $user->username = 'admin';
        $user->phone = '00000000000';
        $user->address = 'Dhaka';
        $user->password = bcrypt(123456789);
        $user->ip_address = request()->ip();
        $user->status = 'a';
        $user->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};