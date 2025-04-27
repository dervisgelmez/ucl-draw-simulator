<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    public static function findFirstStageId()
    {
        return Stage::query()->orderBy('order')->first()->id;
    }
}
