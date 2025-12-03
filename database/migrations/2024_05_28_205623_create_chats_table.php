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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('receiver_id')->nullable()->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->integer('group_id')->nullable();
            $table->longText('message')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('type', ['text', 'image', 'video'])->default('text');
            $table->integer('parent_id')->nullable();
            $table->datetime('read_at')->nullable();
            $table->enum('seen', ['0','1'])->default('0');
            $table->string('deleted_by', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
