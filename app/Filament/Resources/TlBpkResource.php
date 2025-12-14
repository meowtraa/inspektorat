<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TlBpkResource\Pages;
use App\Models\TlBpk;
use App\Imports\TlBpkImport;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;

class TlBpkResource extends Resource
{
    protected static ?string $model = TlBpk::class;

    protected static ?string $navigationGroup = 'Tindak Lanjut';

    protected static ?string $navigationLabel = 'TLHP BPK';

    protected static ?string $pluralModelLabel = 'Tindak Lanjut Hasil Pemeriksaan BPK RI';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    /* =========================
     * FORM (CREATE & EDIT)
     * ========================= */
    public static function form(Form $form): Form
    {
        return $form->schema([

            TextInput::make('nama_skpd')
                ->label('Nama SKPD')
                ->required()
                ->maxLength(255),

            TextInput::make('jumlah_temuan')
                ->label('Jumlah Temuan')
                ->numeric()
                ->minValue(0)
                ->required()
                ->default(0),

            TextInput::make('jumlah_rekomendasi')
                ->label('Jumlah Rekomendasi')
                ->numeric()
                ->minValue(0)
                ->required()
                ->default(0),

            TextInput::make('sesuai')
                ->label('Sesuai')
                ->numeric()
                ->minValue(0)
                ->required()->default(0),

            TextInput::make('belum_sesuai')
                ->label('Belum Sesuai')
                ->numeric()
                ->minValue(0)
                ->required()->default(0),

            TextInput::make('belum_ditindaklanjuti')
                ->label('Belum Ditindaklanjuti')
                ->numeric()
                ->minValue(0)
                ->required()->default(0),

            TextInput::make('tahun')
                ->label('Tahun')
                ->numeric()
                ->default(now()->year)
                ->minValue(2020)
                ->maxValue(now()->year)
                ->required(),

            Select::make('semester')
                ->label('Semester')
                ->options([
                    1 => 'Semester 1',
                    2 => 'Semester 2',
                ])
                ->required(),
        ]);
    }

    /* =========================
     * TABLE
     * ========================= */
    public static function table(Table $table): Table
    {
        return $table->headerActions([

            Tables\Actions\CreateAction::make()
                ->label('Tambah')
                ->icon('heroicon-o-plus-circle'),

            Tables\Actions\Action::make('import_excel')
                ->label('Import Excel')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    \Filament\Forms\Components\TextInput::make('tahun')
                        ->numeric()
                        ->default(now()->year)
                        ->required(),

                    \Filament\Forms\Components\Select::make('semester')
                        ->options([
                            1 => 'Semester 1',
                            2 => 'Semester 2',
                        ])
                        ->required(),

                    \Filament\Forms\Components\FileUpload::make('file')
                        ->disk('local')
                        ->directory('imports')
                        ->required(),
                ])
                ->action(function (array $data) {
                    \Maatwebsite\Excel\Facades\Excel::import(
                        new \App\Imports\TlBpkImport(
                            (int) $data['tahun'],
                            (int) $data['semester']
                        ),
                        \Illuminate\Support\Facades\Storage::path($data['file'])
                    );
                }),
        ])
            ->columns([

                TextColumn::make('nama_skpd')
                    ->label('Nama SKPD')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tahun')
                    ->sortable(),

                TextColumn::make('semester')
                    ->sortable(),

                TextColumn::make('jumlah_rekomendasi')
                    ->label('Rekomendasi')
                    ->sortable(),

                TextColumn::make('sesuai')
                    ->label('Sesuai')
                    ->sortable(),
                TextColumn::make('belum_sesuai')
                    ->label('Belum Sesuai')
                    ->sortable(),

                TextColumn::make('belum_ditindaklanjuti')
                    ->label('Belum Ditindaklanjuti')
                    ->sortable(),

                TextColumn::make('persentase_tl')
                    ->label('Persentase TL')
                    ->badge()
                    ->sortable()
                    ->color(fn ($record) => $record->persentase_tl >= 80 ? 'success'
                        : ($record->persentase_tl >= 60 ? 'warning' : 'danger')
                    )
                    ->formatStateUsing(fn ($state) => number_format($state, 2, ',', '.').' %'
                    ),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(
                        TlBpk::query()
                            ->select('tahun')
                            ->distinct()
                            ->orderBy('tahun', 'desc')
                            ->pluck('tahun', 'tahun')
                    ),

                Tables\Filters\SelectFilter::make('semester')
                    ->label('Semester')
                    ->options([
                        1 => 'Semester 1',
                        2 => 'Semester 2',
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Hapus Terpilih')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->defaultSort('tahun', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTlBpks::route('/'),
            'edit' => Pages\EditTlBpk::route('/{record}/edit'),
        ];
    }
}
