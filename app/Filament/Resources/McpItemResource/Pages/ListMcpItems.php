<?php

namespace App\Filament\Resources\McpItemResource\Pages;

use App\Filament\Resources\McpItemResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ListMcpItems extends ListRecords
{
    protected static string $resource = McpItemResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\McpAreaIndicatorSummary::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->modalHeading('Tambah Indikator MCP KPK'),

            Actions\Action::make('import_excel')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('primary')
                ->modalHeading('Import Checklist MCP dari Excel')
                ->form([

                    Forms\Components\Select::make('area_id')
                        ->label('Area MCP')
                        ->options(\App\Models\McpArea::pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\TextInput::make('year')
                        ->label('Tahun')
                        ->numeric()
                        ->default(now()->year)
                        ->required(),

                    Forms\Components\FileUpload::make('file')
                        ->label('File Excel')
                        ->directory('imports')
                        ->disk('local')
                        ->storeFiles(true)
                        ->preserveFilenames()
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                        ])
                        ->required(),
                ])
                ->action(function (array $data) {

                    $path = Storage::path($data['file']);

                    if (! file_exists($path)) {
                        Notification::make()
                            ->danger()
                            ->title('Gagal Mengimpor')
                            ->body('File Excel tidak ditemukan: '.$path)
                            ->send();

                        return;
                    }

                    Excel::import(
                        new \App\Imports\McpItemImport((int) $data['area_id']),
                        $path
                    );

                    Notification::make()
                        ->success()
                        ->title('Import Berhasil!')
                        ->body('Checklist MCP berhasil diimpor.')
                        ->send();
                }),
        ];
    }
}
