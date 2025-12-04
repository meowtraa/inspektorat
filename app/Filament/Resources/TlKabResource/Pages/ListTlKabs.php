<?php

namespace App\Filament\Resources\TlKabResource\Pages;

use App\Filament\Resources\TlKabResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTlKabs extends ListRecords
{
    protected static string $resource = TlKabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
