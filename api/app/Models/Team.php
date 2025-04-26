<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasUuids;

    protected $guarded = [];

    public function stats(): HasOne
    {
        return $this->hasOne(TeamStat::class);
    }
}
