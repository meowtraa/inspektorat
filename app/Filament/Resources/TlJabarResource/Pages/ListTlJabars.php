<?php

namespace App\Filament\Resources\TlJabarResource\Pages;

use App\Filament\Resources\TlJabarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTlJabars extends ListRecords
{
    protected static string $resource = TlJabarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
