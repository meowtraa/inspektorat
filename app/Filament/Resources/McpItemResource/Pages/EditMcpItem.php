<?php

namespace App\Filament\Resources\McpItemResource\Pages;

use App\Filament\Resources\McpItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMcpItem extends EditRecord
{
    protected static string $resource = McpItemResource::class;

    protected static ?string $title = 'Edit Checklist MCP';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
