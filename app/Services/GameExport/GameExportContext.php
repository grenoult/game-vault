<?php

namespace App\Services\GameExport;

use App\Services\GameExport\GameExportStrategies\GameExportCsv;
use App\Services\GameExport\GameExportStrategies\GameExportStrategyInterface;
use App\Services\GameExport\GameExportStrategies\GameExportXml;
use Illuminate\Database\Eloquent\Collection;

/**
 * The Context class is the entry point for the rest of the application: controllers and services call this class to
 * generate an export, which is handled internally.
 */
class GameExportContext
{
    private GameExportStrategyInterface $strategy;

    /**
     * List of strategies and their concrete class.
     * Later on, this can be updated to be automatic instead of a key value array.
     */
    const STRATEGIES = [
        'csv' => GameExportCsv::class,
        'xml' => GameExportXml::class,
    ];

    /**
     * @param GameExportStrategyInterface $strategy
     */
    public function setStrategy(GameExportStrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * @param Collection|array $games
     * @return string
     */
    public function execute(Collection|array $games): string
    {
        return $this->strategy->format($games);
    }
}
