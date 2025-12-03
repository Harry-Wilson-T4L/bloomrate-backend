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
        Schema::table('posts', function (Blueprint $table) {
            //
            Schema::table('posts', function (Blueprint $table) {
                // Single-column indexes
                $table->index('user_id', 'idx_posts_user_id');
                $table->index('is_block', 'idx_posts_is_block');
                $table->index('interest_id', 'idx_posts_interest_id');
                $table->index('post_type', 'idx_posts_post_type');
                $table->index('group_id', 'idx_posts_group_id');
                $table->index('is_group_post', 'idx_posts_is_group_post');
                $table->index('created_at', 'idx_posts_created_at');
    
                // Composite indexes (order matters - leftmost prefix)
                // Query patterns:
                // - WHERE group_id = ? AND is_group_post = 0 AND is_block = 0 ORDER BY created_at DESC
                $table->index(['group_id', 'is_group_post', 'is_block', 'created_at'], 'idx_posts_group_grpflag_block_created');
    
                // - WHERE interest_id = ? AND is_block = 0
                $table->index(['interest_id', 'is_block'], 'idx_posts_interest_block');
    
                // - WHERE post_type = ? AND is_block = 0
                $table->index(['post_type', 'is_block'], 'idx_posts_posttype_block');
    
                // - WHERE user_id = ? AND is_block = 0 (useful for fetching a user's posts)
                $table->index(['user_id', 'is_block', 'created_at'], 'idx_posts_user_block_created');
            });
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('idx_posts_user_id');
            $table->dropIndex('idx_posts_is_block');
            $table->dropIndex('idx_posts_interest_id');
            $table->dropIndex('idx_posts_post_type');
            $table->dropIndex('idx_posts_group_id');
            $table->dropIndex('idx_posts_is_group_post');
            $table->dropIndex('idx_posts_created_at');

            $table->dropIndex('idx_posts_group_grpflag_block_created');
            $table->dropIndex('idx_posts_interest_block');
            $table->dropIndex('idx_posts_posttype_block');
            $table->dropIndex('idx_posts_user_block_created');
        });

    }
};
