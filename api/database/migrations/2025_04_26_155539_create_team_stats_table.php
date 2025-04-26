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
        Schema::create('team_stats', function (Blueprint $table) {
            $table->id();
            $table->uuid('team_id');
            $table->tinyInteger('attack');
            $table->tinyInteger('midfield');
            $table->tinyInteger('defense');
            $table->tinyInteger('speed');
            $table->tinyInteger('pass');
            $table->tinyInteger('shot');
            $table->smallInteger('squad_depth');
            $table->tinyInteger('injury_risk');
            $table->tinyInteger('home_advantage');
            $table->smallInteger('min_temp_performance');
            $table->smallInteger('max_temp_performance');
            $table->tinyInteger('winner_mentality');
            $table->tinyInteger('loser_mentality');
            $table->tinyInteger('star_players_count');
            $table->tinyInteger('manager_influence');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_stats');
    }
};
