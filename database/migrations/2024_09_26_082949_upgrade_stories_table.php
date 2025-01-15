<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            if (Schema::hasColumn('stories', 'comment_visibility')) {
                $table->dropColumn('comment_visibility');
            }
            $table->unsignedBigInteger('views_count')->default(0)->index()->after('meta');
            $table->boolean('is_comments_disabled')->default(false)->after('featured');
            $table->boolean('is_nsfw')->default(false)->after('is_comments_disabled');
            $table->fullText('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('view_count');
            $table->dropColumn('is_comments_disabled');
            $table->dropColumn('is_nsfw');
            $table->dropFullText('title');
        });
    }
};
