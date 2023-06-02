<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Student', '192.1k'),
            Card::make('Total Classes', '21%'),
            Card::make('Total Section', '3:12'),
        ];
    }
}
