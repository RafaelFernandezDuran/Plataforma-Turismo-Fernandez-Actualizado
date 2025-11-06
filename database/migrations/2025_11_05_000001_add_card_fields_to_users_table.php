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
        Schema::table('users', function (Blueprint $table) {
            $table->string('card_token', 64)->nullable()->after('remember_token');
            $table->string('card_brand', 32)->nullable()->after('card_token');
            $table->string('card_last_four', 4)->nullable()->after('card_brand');
            $table->string('card_expiry', 5)->nullable()->after('card_last_four');
            $table->string('card_holder', 120)->nullable()->after('card_expiry');
            $table->timestamp('card_saved_at')->nullable()->after('card_holder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'card_token',
                'card_brand',
                'card_last_four',
                'card_expiry',
                'card_holder',
                'card_saved_at',
            ]);
        });
    }
};
