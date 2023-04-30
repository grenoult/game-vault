<?php

namespace Tests\Unit;

use \App\Services\GameExport;
use \App\Models\Game;
use PHPUnit\Framework\Attributes\DataProvider;
use \PHPUnit\Framework\TestCase;

class GameExportTest extends TestCase
{
    /**
     * @return Game[]
     */
    public static function create_fixtures(): array
    {
        $game1 = new Game();
        $game1->id = 1;
        $game1->title = 'Doom';
        $game1->setCreatedAt(null);
        $game1->setUpdatedAt(null);

        $game2 = new Game();
        $game2->id = 2;
        $game2->title = 'SimCity';
        $game2->setCreatedAt(null);
        $game2->setUpdatedAt(null);

        $game3 = new Game();
        $game3->id = 3;
        $game3->title = 'Oregon Trail Deluxe';
        $game3->setCreatedAt(null);
        $game3->setUpdatedAt(null);

        return [$game1, $game2, $game3];
    }

    public static function data_export_to_csv(): array
    {
        $games = self::create_fixtures();

        return [
            'Export multiple records' => [
                $games, // data
                "id,title\n1,Doom\n2,SimCity\n3,Oregon Trail Deluxe\n"
            ],
            'Export one record' => [
                [$games[0]], // data
                "id,title\n1,Doom\n"
            ],
            'Export no record' => [
                [], // data
                "id,title\n"
            ],
        ];
    }

    #[DataProvider('data_export_to_csv')]
    public function test_export_to_csv($data, $expectedResult): void
    {
        $exporter = new GameExport();
        $result = $exporter->toCsv($data);

        $this->assertEquals($expectedResult, $result);
    }

    public static function data_export_to_json(): array
    {
        $games = self::create_fixtures();

        return [
            'Export multiple records' => [
                $games, // data
                '[{"id":1,"title":"Doom"},{"id":2,"title":"SimCity"},{"id":3,"title":"Oregon Trail Deluxe"}]'
            ],
            'Export one record' => [
                [$games[0]], // data
                '[{"id":1,"title":"Doom"}]'
            ],
            'Export no record' => [
                [], // data
                '[]'
            ],
        ];
    }

    #[DataProvider('data_export_to_json')]
    public function test_export_to_json($data, $expectedResult): void
    {
        $exporter = new GameExport();
        $result = $exporter->toJson($data);

        $this->assertEquals($expectedResult, $result);
    }
}
