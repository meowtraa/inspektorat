<?php

namespace App\Filament\Resources\TlBpkResource\Pages;

use App\Filament\Resources\TlBpkResource;
use App\Models\TlBpk;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTlBpk extends EditRecord
{
    protected static string $resource = TlBpkResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $exists = TlBpk::where('nama_skpd', $data['nama_skpd'])
            ->where('tahun', $data['tahun'])
            ->where('semester', $data['semester'])
            ->where('id', '!=', $this->record->id) // penting!
            ->exists();

        if ($exists) {
            Notification::make()
                ->danger()
                ->title('Data duplikat!')
                ->body('Data untuk SKPD ini sudah ada pada tahun & semester tersebut.')
                ->send();

            $this->halt(); // hentikan update
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
