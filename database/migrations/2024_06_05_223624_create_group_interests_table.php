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
        Schema::create('group_interests', function (Blueprint $table) {
            $table->id();
             $table->foreignId('group_id')->references('id')->on('groups')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('interest_id')->references('id')->on('interests')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_interests');
    }
};
