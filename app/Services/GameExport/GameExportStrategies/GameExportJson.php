<?php

namespace App\Services\GameExport\GameExportStrategies;

use Illuminate\Database\Eloquent\Collection;

class GameExportJson implements GameExportStrategyInterface
{
    public function format(Collection|array $games): string
    {
        $json = [];
        foreach ($games as $game) {
            $json[] = [
                'id' => $game->id,
                'title' => $game->title,
            ];
        }
        return json_encode($json);
    }
}
