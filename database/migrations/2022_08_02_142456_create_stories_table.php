<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('community_id')->nullable()->constrained('communities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title')->index();
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->json('body')->nullable();
            $table->text('body_rendered');
            $table->string('canonical_url')->nullable();
            $table->boolean('is_pinned')->default(0);
            $table->boolean('featured')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->dateTime('published_at')->nullable()->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
};
