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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('user_type', ['admin', 'user'])->default('user');
            $table->string('profession')->nullable();
            $table->integer('status_id')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            // $table->string('address')->nullable();
            // $table->string('latitude')->nullable();
            // $table->string('longitude')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('age')->nullable();
            $table->longText('bio')->nullable();

            $table->rememberToken()->nullable();
            $table->enum('is_profile_complete', ['0','1'])->default('0');
            $table->enum('device_type', ['ios','android','web'])->nullable();
            $table->longText('device_token')->nullable();
            $table->enum('social_type', ['google','facebook','twitter','instagram','apple','phone'])->nullable();
            $table->longText('social_token')->nullable();
            $table->enum('is_forgot', ['0','1'])->default('0');

            $table->enum('push_notification', ['0','1'])->default('1');
            $table->enum('post_comment_notification', ['0','1'])->default('0');
            $table->enum('follower_notification', ['0','1'])->default('1');
            $table->enum('is_sharing', ['0','1'])->default('0');
            $table->enum('is_phone_book', ['0','1'])->default('0');

            $table->enum('is_verified', ['0','1'])->default('0');
            $table->enum('is_admin', ['0','1'])->default('0');
            $table->enum('is_social', ['0','1'])->default('0');
            $table->integer('verified_code')->nullable();
            $table->enum('is_active', ['0','1'])->default('1');
            $table->enum('is_blocked', ['0','1'])->default('0');
            $table->enum('is_profile_private', ['0','1'])->default('0');
            $table->enum('online_status', ['offline','online'])->default('online');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
