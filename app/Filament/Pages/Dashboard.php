<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Dashboard Inspektorat';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Resources\HeaderResource\Widgets\HeadingSectionBpk::class,
            \App\Filament\Resources\TlBpkResource\Widgets\TlBpkSummary::class,
            // \App\Filament\Widgets\TopBpkChart::class,
            \App\Filament\Resources\HeaderResource\Widgets\HeadingSectionJabar::class,
            \App\Filament\Resources\TlJabarResource\Widgets\TlJabarSummary::class,
            // \App\Filament\Widgets\TopJabarChart::class,
            \App\Filament\Resources\HeaderResource\Widgets\HeadingSectionKab::class,
            \App\Filament\Resources\TlKabResource\Widgets\TlKabSummary::class,
            // \App\Filament\Widgets\TopKabChart::class,

        ];
    }
}
