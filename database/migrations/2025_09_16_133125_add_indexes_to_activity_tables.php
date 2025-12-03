<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        // comments
        Schema::table('comments', function (Blueprint $table) {
            $table->index('post_id', 'idx_comments_post_id');
            $table->index('user_id', 'idx_comments_user_id');
            $table->index(['post_id', 'created_at'], 'idx_comments_post_created');
        });

        // likes
        Schema::table('likes', function (Blueprint $table) {
            $table->index('record_id', 'idx_likes_record_id'); // if likes used for posts -> record_id = post id
            $table->index('user_id', 'idx_likes_user_id');
            $table->index(['record_id', 'like_type'], 'idx_likes_record_like_type'); // filter by like_type=post
        });

        // post_views
        Schema::table('post_views', function (Blueprint $table) {
            $table->index('post_id', 'idx_postviews_post_id');
            $table->index('user_id', 'idx_postviews_user_id');
            $table->index(['post_id', 'user_id'], 'idx_postviews_post_user');
        });

        // favorites (or save_posts)
        Schema::table('favorites', function (Blueprint $table) {
            $table->index('post_id', 'idx_fav_post_id');
            $table->index('user_id', 'idx_fav_user_id');
            $table->unique(['user_id', 'post_id'], 'uniq_fav_user_post'); // if design allows unique per user-post
        });

        // saves table (if different name)
        Schema::table('save_posts', function (Blueprint $table) {
            $table->index(['user_id', 'post_id'], 'idx_saveposts_user_post');
        });
    }


    /**
     * Reverse the migrations.
     */
        public function down() : void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('idx_comments_post_id');
            $table->dropIndex('idx_comments_user_id');
            $table->dropIndex('idx_comments_post_created');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropIndex('idx_likes_record_id');
            $table->dropIndex('idx_likes_user_id');
            $table->dropIndex('idx_likes_record_like_type');
        });

        Schema::table('post_views', function (Blueprint $table) {
            $table->dropIndex('idx_postviews_post_id');
            $table->dropIndex('idx_postviews_user_id');
            $table->dropIndex('idx_postviews_post_user');
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropIndex('idx_fav_post_id');
            $table->dropIndex('idx_fav_user_id');
            $table->dropUnique('uniq_fav_user_post');
        });

        Schema::table('save_posts', function (Blueprint $table) {
            $table->dropIndex('idx_saveposts_user_post');
        });
    }

};
