<?php

namespace App\Models;

use App\Observers\FixtureObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([FixtureObserver::class])]
class Fixture extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $guarded = [];

    public function groups(): HasMany
    {
        return $this->hasMany(FixtureGroup::class);
    }

    public static function findOneByActive()
    {
        return Fixture::query()->orderByDesc('created_at')->first();
    }
}
