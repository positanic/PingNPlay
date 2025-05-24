<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('pickup_games', function (Blueprint $table) {
            $table->integer('min_players')->nullable()->change();
            $table->integer('max_players')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('pickup_games', function (Blueprint $table) {
            $table->integer('min_players')->nullable(false)->change();
            $table->integer('max_players')->nullable(false)->change();
        });
    }
};
