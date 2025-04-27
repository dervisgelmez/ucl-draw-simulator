<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixture_matches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fixture_id')->constrained('fixtures')->cascadeOnDelete();
            $table->foreignId('stage_id')->constrained('stages');
            $table->tinyInteger('week');
            $table->foreignUuid('home_team_id')->constrained('teams');
            $table->foreignUuid('away_team_id')->constrained('teams');
            $table->tinyInteger('home_score')->nullable();
            $table->tinyInteger('away_score')->nullable();
            $table->dateTime('match_date')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_matches');
    }
};
