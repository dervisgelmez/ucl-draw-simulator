<?php

use App\Enums\FixtureStageEnum;
use App\Supports\Enum;
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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('fixture_stage_id', Enum::values(FixtureStageEnum::class))->default(FixtureStageEnum::GROUP_STAGE->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
