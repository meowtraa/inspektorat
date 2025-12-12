<?php

namespace App\Filament\Resources\McpAreaResource\Pages;

use App\Filament\Resources\McpAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMcpArea extends EditRecord
{
    protected static string $resource = McpAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
