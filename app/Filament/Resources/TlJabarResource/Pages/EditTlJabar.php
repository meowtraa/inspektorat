<?php

namespace App\Filament\Resources\TlJabarResource\Pages;

use App\Filament\Resources\TlJabarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTlJabar extends EditRecord
{
    protected static string $resource = TlJabarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
