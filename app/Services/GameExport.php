<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GameExport
{
    /**
     * @param Collection|Game[] $games
     * @return string
     */
    function toCsv(Collection|array $games): string
    {
        $csv = "id,title\n";
        foreach ($games as $game) {
            $csv .= "{$game->id},{$game->title}\n";
        }
        return $csv;
    }
}
