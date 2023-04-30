<?php

namespace Tests\Unit;

use \App\Services\GameExport;
use \App\Models\Game;
use \PHPUnit\Framework\TestCase;

class GameExportTest extends TestCase
{
    public static function data_export_to_csv(): array
    {
        $game1 = new Game();
        $game1->id = 1;
        $game1->title = 'Doom';

        $game2 = new Game();
        $game2->id = 2;
        $game2->title = 'SimCity';

        $game3 = new Game();
        $game3->id = 3;
        $game3->title = 'Oregon Trail Deluxe';

        return [
            'Export multiple records' => [
                [$game1, $game2, $game3], // data
                "id,title\n1,Doom\n2,SimCity\n3,Oregon Trail Deluxe\n"
            ],
            'Export one record' => [
                [$game1], // data
                "id,title\n1,Doom\n"
            ],
            'Export no record' => [
                [], // data
                "id,title\n"
            ],
        ];
    }

    /**
     * @param $data
     * @param $expectedResult
     * @return void
     * @dataProvider data_export_to_csv
     */
    public function test_export_to_csv($data, $expectedResult): void
    {
        $exporter = new GameExport();
        $result = $exporter->toCsv($data);

        $this->assertEquals($expectedResult, $result);
    }

    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
