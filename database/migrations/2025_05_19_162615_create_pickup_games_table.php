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
        Schema::create('pickup_games', function (Blueprint $table) {
            $table->id();
            $table->date('game_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('location');
            $table->text('location_details')->nullable();
            $table->integer('max_players')->default(20);
            $table->integer('min_players')->default(10);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Allows for archiving games instead of permanent deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_games');
    }
};
