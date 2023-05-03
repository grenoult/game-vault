<?php

namespace App\Services\GameExport;

use App\Services\GameExport\GameExportStrategies\GameExportStrategyInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * The Context class is the entry point for the rest of the application: controllers and services call this class to
 * generate an export, which is handled internally.
 */
class GameExportContext
{
    private GameExportStrategyInterface $strategy;

    /**
     * Get the name of a concrete strategy by name, or null if it doesn't exist.
     *
     * @param $name
     * @return string|null
     */
    public function loadStrategyByName($name): ?string
    {
        $className = sprintf(
            'App\Services\GameExport\GameExportStrategies\GameExport%s',
            ucfirst(strtolower($name))
        );

        return class_exists($className) ? $className : null;
    }

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
