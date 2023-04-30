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
    public function toCsv(Collection|array $games): string
    {
        $csv = "id,title\n";
        foreach ($games as $game) {
            $csv .= "{$game->id},{$game->title}\n";
        }
        return $csv;
    }

    /**
     * @param Collection|Game[] $games
     * @return string
     */
    public function toJson(Collection|array $games): string
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
