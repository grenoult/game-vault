<?php

namespace App\Services\GameExport\GameExportStrategies;

use Illuminate\Database\Eloquent\Collection;

class GameExportCsv implements GameExportStrategyInterface
{
    public function format(Collection|array $games): string
    {
        $csv = "id,title\n";
        foreach ($games as $game) {
            $csv .= "{$game->id},{$game->title}\n";
        }
        return $csv;
    }
}
