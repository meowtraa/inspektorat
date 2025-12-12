<?php

namespace App\Filament\Resources\McpAreaResource\Pages;

use App\Filament\Resources\McpAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMcpAreas extends ListRecords
{
    protected static string $resource = McpAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading('Tambah Area MCP KPK')
                ->modalButton('Simpan')
                ->label('Tambah'),
        ];
    }
}
