<?php

namespace App\Filament\Resources\TlBpkResource\Pages;

use App\Filament\Resources\TlBpkResource;
use App\Imports\TlBpkImport;
use App\Models\TlBpk;
use Filament\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListTlBpks extends ListRecords
{
    protected static string $resource = TlBpkResource::class;

    /* =========================
     * HEADER WIDGET
     * ========================= */
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\TlBpkResource\Widgets\TlBpkSummary::class,
        ];
    }

    protected function getHeaderWidgetsPosition(): WidgetsPosition
    {
        return WidgetsPosition::AboveContent;
    }

    /* =========================
     * HEADER ACTIONS
     * ========================= */
    protected function getHeaderActions(): array
    {
        return [

            // /* ===== CREATE ===== */
            // Actions\CreateAction::make()
            //     ->label('Tambah Tindak Lanjut')
            //     ->icon('heroicon-o-plus-circle')
            //     ->modalHeading('Tambah Data Tindak Lanjut BPK')
            //     ->createAnother(false)
            //     ->modalSubmitActionLabel('Simpan Data')
            //     ->modalCancelActionLabel('Batal')

            //     // validasi duplikat
            //     ->before(function (Actions\CreateAction $action, array $data) {

            //         $exists = TlBpk::query()
            //             ->where('nama_skpd', $data['nama_skpd'])
            //             ->where('tahun', $data['tahun'])
            //             ->where('semester', $data['semester'])
            //             ->exists();

            //         if ($exists) {
            //             Notification::make()
            //                 ->danger()
            //                 ->title('Data duplikat')
            //                 ->body('Data SKPD ini sudah ada pada tahun & semester tersebut.')
            //                 ->send();

            //             $action->halt();
            //         }
            //     }),

            // /* ===== IMPORT EXCEL ===== */
            // Actions\Action::make('import_excel')
            //     ->label('Import Excel')
            //     ->icon('heroicon-o-arrow-up-tray')
            //     ->color('primary')
            //     ->modalHeading('Import Data TL BPK dari Excel')
            //     ->form([

            //         TextInput::make('tahun')
            //             ->label('Tahun')
            //             ->numeric()
            //             ->default(now()->year)
            //             ->required(),

            //         Select::make('semester')
            //             ->label('Semester')
            //             ->options([
            //                 1 => 'Semester 1',
            //                 2 => 'Semester 2',
            //             ])
            //             ->required(),

            //         FileUpload::make('file')
            //             ->label('File Excel')
            //             ->disk('local')
            //             ->directory('imports')
            //             ->preserveFilenames()
            //             ->acceptedFileTypes([
            //                 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            //                 'application/vnd.ms-excel',
            //             ])
            //             ->required(),
            //     ])
            //     ->action(function (array $data) {

            //         $path = Storage::path($data['file']);

            //         if (! file_exists($path)) {
            //             Notification::make()
            //                 ->danger()
            //                 ->title('Gagal Import')
            //                 ->body('File Excel tidak ditemukan.')
            //                 ->send();

            //             return;
            //         }

            //         Excel::import(
            //             new TlBpkImport(
            //                 (int) $data['tahun'],
            //                 (int) $data['semester']
            //             ),
            //             $path
            //         );

            //         Notification::make()
            //             ->success()
            //             ->title('Import Berhasil')
            //             ->body('Data TL BPK berhasil diimport.')
            //             ->send();
            //     }),
        ];
    }
}
