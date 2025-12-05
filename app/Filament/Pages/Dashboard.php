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
            \App\Filament\Resources\TlKabResource\Widgets\TlKabSummary::class,
            \App\Filament\Widgets\TopBpkChart::class,

        ];
    }

    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'md' => 1,
            'lg' => 1,
            'xl' => 1,
        ];
    }
}
