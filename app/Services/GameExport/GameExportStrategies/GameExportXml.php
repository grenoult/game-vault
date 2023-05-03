<?php

namespace App\Services\GameExport\GameExportStrategies;

use Illuminate\Database\Eloquent\Collection;

class GameExportXml implements GameExportStrategyInterface
{
    public function format(Collection|array $games): string
    {
        $xml = "<?xml version=\"1.0\"?>\n";
        $xml .= "<games>\n";
        foreach ($games as $game) {
            $xml .= "    <game>\n";
            $xml .= "        <id>$game->id</id>\n";
            $xml .= "        <title>$game->title</title>\n";
            $xml .= "    </game>\n";
        }
        $xml .= "</games>\n";
        return $xml;
    }
}
