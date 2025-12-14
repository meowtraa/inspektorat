<?php

namespace App\Filament\Resources\McpAreaScoreResource\Pages;

use App\Filament\Resources\McpAreaScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;use App\Filament\Resources\McpAreaScoreResource\Widgets\McpTotalSummary;
use App\Filament\Resources\McpAreaScoreResource\Widgets\McpSummary;
class ListMcpAreaScores extends ListRecords
{
    protected static string $resource = McpAreaScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }    protected function getHeaderWidgets(): array
    {
        return [
               McpTotalSummary::class,
        McpSummary::class,
        ];
    }
 
}