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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('interest_id')->references('id')->on('interests')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('title');
            $table->enum('post_type', ['thoughts', 'photo', 'video']);
            $table->string('media')->nullable();
            $table->string('media_type')->nullable();
            $table->string('media_thumbnail')->nullable();
            $table->enum('is_share', ['0', '1'])->default('0');
            $table->integer('group_id')->nullable();
            $table->enum('is_group_post', ['0', '1'])->default('0');
            $table->foreignId('parent_id')->nullable()->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('is_block', ['0', '1'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
