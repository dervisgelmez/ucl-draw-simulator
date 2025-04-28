<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $guarded = [];

    public static function findFirstStageId()
    {
        return Stage::query()->orderBy('order')->first()->id;
    }

    public static function findNextStageId(Stage $stage)
    {
        return Stage::query()->where('order', ($stage->order + 1))->first()->id;
    }
}
