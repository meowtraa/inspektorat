<?php

namespace App\Filament\Resources\McpAreaScoreResource\Pages;

use App\Filament\Resources\McpAreaScoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMcpAreaScore extends EditRecord
{
    protected static string $resource = McpAreaScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
