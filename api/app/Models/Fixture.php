<?php

namespace App\Models;

use App\Observers\FixtureObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([FixtureObserver::class])]
class Fixture extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    public function stage(): HasOne
    {
        return $this->hasOne(Stage::class, 'id', 'stage_id');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(FixtureGroup::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(FixtureMatch::class);
    }

    public static function findOneByActive()
    {
        return Fixture::query()
            ->with(['stage'])
            ->orderByDesc('created_at')
            ->first();
    }
}
