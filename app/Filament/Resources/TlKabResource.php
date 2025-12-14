<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TlKabResource\Pages;
use App\Models\TlKab;
use App\Imports\TlKabImport;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TlKabResource extends Resource
{
    protected static ?string $model = TlKab::class;

    protected static ?string $navigationGroup = 'Tindak Lanjut';

    protected static ?string $navigationLabel = 'TL IPDA Kab. Tasikmalaya';

    protected static ?string $pluralModelLabel =
        'Tindak Lanjut Hasil Pemeriksaan Inspektorat Daerah Kab. Tasikmalaya';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

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
                ->default(0)
                ->required(),

            TextInput::make('jumlah_rekomendasi')
                ->label('Jumlah Rekomendasi')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->required(),

            TextInput::make('sesuai')
                ->label('Sesuai')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->required(),

            TextInput::make('belum_sesuai')
                ->label('Belum Sesuai')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->required(),

            TextInput::make('belum_ditindaklanjuti')
                ->label('Belum Ditindaklanjuti')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->required(),

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
        return $table
            ->headerActions([

                /* ===== TAMBAH ===== */
                CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-o-plus-circle'),

                /* ===== IMPORT EXCEL ===== */
                Action::make('import_excel')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->form([
                        TextInput::make('tahun')
                            ->numeric()
                            ->default(now()->year)
                            ->required(),

                        Select::make('semester')
                            ->options([
                                1 => 'Semester 1',
                                2 => 'Semester 2',
                            ])
                            ->required(),

                        FileUpload::make('file')
                            ->disk('local')
                            ->directory('imports')
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        Excel::import(
                            new TlKabImport(
                                (int) $data['tahun'],
                                (int) $data['semester']
                            ),
                            Storage::path($data['file'])
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
                    ->color(fn ($record) =>
                        $record->persentase_tl >= 80
                            ? 'success'
                            : ($record->persentase_tl >= 60 ? 'warning' : 'danger')
                    )
                    ->formatStateUsing(
                        fn ($state) => number_format($state, 2, ',', '.') . ' %'
                    ),
            ])
            ->filters([

                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(
                        TlKab::query()
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
            'index' => Pages\ListTlKabs::route('/'),
            'edit' => Pages\EditTlKab::route('/{record}/edit'),
        ];
    }
}
