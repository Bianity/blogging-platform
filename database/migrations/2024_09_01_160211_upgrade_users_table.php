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
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('rating')->index()->default(0)->after('password');
            $table->json('notify_settings')->nullable()->after('rating');
            $table->json('preference_settings')->nullable()->after('notify_settings');
            $table->boolean('google2fa_status')->nullable()->default(false)->after('provider_id');
            $table->text('google2fa_secret')->nullable()->after('google2fa_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rating');
            $table->dropColumn('notify_settings');
            $table->dropColumn('preference_settings');
            $table->dropColumn('google2fa_status');
            $table->dropColumn('google2fa_secret');
        });
    }
};
