<?php

namespace App\Services\Simulate;

use App\Models\Fixture;

interface SimulateStrategy
{
    public function handle(Fixture $fixture);
}
