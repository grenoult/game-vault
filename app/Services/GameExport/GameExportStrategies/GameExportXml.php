<?php

namespace App\Services\GameExport\GameExportStrategies;

use Illuminate\Database\Eloquent\Collection;

class GameExportXml implements GameExportStrategyInterface
{
    public function format(Collection|array $games): string
    {
        $xml = "<?xml version=\"1.0\"?>";
        $xml .= "<games>";
        foreach ($games as $game) {
            $xml .= "<game>";
            $xml .= "<id>$game->id</id>";
            $xml .= "<title>$game->title</title>";
            $xml .= "</game>";
        }
        $xml .= "</games>";
        return $xml;
    }
}
