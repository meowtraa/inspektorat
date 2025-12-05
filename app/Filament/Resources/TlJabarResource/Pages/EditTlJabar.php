<?php

namespace App\Filament\Resources\TlJabarResource\Pages;

use App\Filament\Resources\TlJabarResource;
use App\Models\TlJabar;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTlJabar extends EditRecord
{
    protected static string $resource = TlJabarResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $exists = TlJabar::where('nama_skpd', $data['nama_skpd'])
            ->where('tahun', $data['tahun'])
            ->where('semester', $data['semester'])
            ->where('id', '!=', $this->record->id)
            ->exists();

        if ($exists) {
            Notification::make()
                ->danger()
                ->title('Data duplikat!')
                ->body('Data untuk SKPD ini sudah ada pada tahun & semester tersebut.')
                ->send();

            $this->halt();
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
