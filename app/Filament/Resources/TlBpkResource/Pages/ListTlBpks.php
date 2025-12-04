<?php

namespace App\Filament\Resources\TlBpkResource\Pages;

use App\Filament\Resources\TlBpkResource;
use App\Models\TlBpk;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListTlBpks extends ListRecords
{
    protected static string $resource = TlBpkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tindak Lanjut')
                ->icon('heroicon-o-plus-circle')
                ->modalHeading('Tambah Data Tindak Lanjut BPK')    
                ->createAnother(false)
                ->modalSubmitActionLabel('Simpan Data')
                ->modalCancelActionLabel('Batal')
                ->before(function (Actions\CreateAction $action, array $data) {
                    $exists = TlBpk::where('nama_skpd', $data['nama_skpd'])
                        ->where('tahun', $data['tahun'])
                        ->where('semester', $data['semester'])
                        ->exists();

                    if ($exists) {
                        Notification::make()
                            ->danger()
                            ->title('Data duplikat!')
                            ->body('Data untuk SKPD ini sudah ada pada tahun & semester tersebut.')
                            ->send();

                        $action->halt();
                    }
                }),
        ];
    }
}
