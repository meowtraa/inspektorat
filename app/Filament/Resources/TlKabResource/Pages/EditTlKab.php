<?php

namespace App\Filament\Resources\TlKabResource\Pages;

use App\Filament\Resources\TlKabResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTlKab extends EditRecord
{
    protected static string $resource = TlKabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
