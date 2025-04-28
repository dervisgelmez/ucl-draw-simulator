<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixtureMatch extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    public function stage(): HasOne
    {
        return $this->hasOne(Stage::class, 'id', 'stage_id');
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id')->with(['stats']);
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id')->with(['stats']);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(FixtureMatchLog::class);
    }

    public static function findByStage(Fixture $fixture, string $stage): Collection
    {
        return $fixture
            ->matches()
            ->with(['stage', 'homeTeam', 'awayTeam'])
            ->whereHas('stage', function ($query) use ($stage) {
                $query->where('name', $stage);
            })
            ->orderBy('match_date')
            ->get();
    }
}
