<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function stats(): HasOne
    {
        return $this->hasOne(TeamStat::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(FixtureGroup::class, 'fixture_group_teams');
    }

    public static function getActiveTeams(): Collection
    {
        return Team::query()->with(['stats'])->orderBy('name')->get();
    }
}
