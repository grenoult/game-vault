<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;
use \Tests\TestCase;

class GameTest extends TestCase
{
    use DatabaseTransactions;

    /** @var Collection[Games] $games */
    private Collection $games;

    private User $user;

    /**
     * Initiate fixtures that can be reused in all tests.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Truncate table: usefule to reset auto increment value for Game primary key
        DB::table('games')->truncate();

        $this->user = User::factory()->create();

        // Create 10 games with name `Game 1`, `Game 2`, etc.
        $this->games = Game::factory()
            ->count(10)
            ->state(new Sequence(
                fn (Sequence $sequence) => ['user_id' => $this->user, 'title' => 'Game '.$sequence->index+1]
            ))
            ->create();
    }

    public function test_games_exported_to_json(): void
    {
        $expectedResult = '[{"id":1,"title":"Game 1"},{"id":2,"title":"Game 2"},{"id":3,"title":"Game 3"},'.
            '{"id":4,"title":"Game 4"},{"id":5,"title":"Game 5"},{"id":6,"title":"Game 6"},'.
            '{"id":7,"title":"Game 7"},{"id":8,"title":"Game 8"},{"id":9,"title":"Game 9"},'.
            '{"id":10,"title":"Game 10"}]';

        $response = $this
            ->actingAs($this->user)
            ->get('/games/export/json');

        $response->assertContent($expectedResult);
    }

    public function test_games_exported_to_csv(): void
    {
        $expectedResult = 'id,title
1,Game 1
2,Game 2
3,Game 3
4,Game 4
5,Game 5
6,Game 6
7,Game 7
8,Game 8
9,Game 9
10,Game 10
';

        $response = $this
            ->actingAs($this->user)
            ->get('/games/export/csv');

        $response->assertContent($expectedResult);
    }

    public function test_games_exported_to_xml(): void
    {
        $expectedResult = '<?xml version="1.0"?>
<games>
    <game>
        <id>1</id>
        <title>Game 1</title>
    </game>
    <game>
        <id>2</id>
        <title>Game 2</title>
    </game>
    <game>
        <id>3</id>
        <title>Game 3</title>
    </game>
    <game>
        <id>4</id>
        <title>Game 4</title>
    </game>
    <game>
        <id>5</id>
        <title>Game 5</title>
    </game>
    <game>
        <id>6</id>
        <title>Game 6</title>
    </game>
    <game>
        <id>7</id>
        <title>Game 7</title>
    </game>
    <game>
        <id>8</id>
        <title>Game 8</title>
    </game>
    <game>
        <id>9</id>
        <title>Game 9</title>
    </game>
    <game>
        <id>10</id>
        <title>Game 10</title>
    </game>
</games>
';

        $response = $this
            ->actingAs($this->user)
            ->get('/games/export/xml');

        $response->assertContent($expectedResult);
    }
}
