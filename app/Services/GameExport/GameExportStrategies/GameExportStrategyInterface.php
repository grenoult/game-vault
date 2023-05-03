<?php

namespace App\Services\GameExport\GameExportStrategies;

use Illuminate\Database\Eloquent\Collection;

interface GameExportStrategyInterface
{
    public function format(Collection|array $games): string;
}
