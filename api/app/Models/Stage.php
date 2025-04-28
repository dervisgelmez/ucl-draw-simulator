<?php

namespace App\Models;

use App\Enums\StageEnum;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $guarded = [];

    public static function findOneByEnum(StageEnum $enum)
    {
        return Stage::query()->where('order', $enum->order())->first();
    }
}
