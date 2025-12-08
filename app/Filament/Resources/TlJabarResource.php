<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TlJabarResource\Pages;
use App\Models\TlJabar;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TlJabarResource extends Resource
{
    protected static ?string $model = TlJabar::class;

    protected static ?string $navigationGroup = 'Tindak Lanjut';

    protected static ?string $navigationLabel = 'TL IPDA Jabar';

    protected static ?string $pluralModelLabel = 'Tindak Lanjut Hasil Pemeriksaan Inspektorat Daerah Provinsi Jawa Barat';

    protected static ?string $icon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_skpd')
                    ->label('Nama SKPD')
                    ->placeholder('Masukkan nama SKPD')
                    ->markAsRequired()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Nama SKPD wajib diisi.',
                    ]),

                TextInput::make('persentase_tl')
                    ->suffix('%')
                    ->label('Persentase TL (%)')
                    ->numeric()
                    ->placeholder('Contoh: 80.50')
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0)
                    ->markAsRequired()
                    ->rules(['required', 'numeric', 'min:0', 'max:100'])
                    ->validationMessages([
                        'required' => 'Persentase wajib diisi.',
                        'numeric' => 'Persentase harus berupa angka.',
                        'min' => 'Persentase minimal 0%.',
                        'max' => 'Persentase maksimal 100%.',
                    ]),

                TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->default(date('Y'))
                    ->minValue(2020)
                    ->maxValue(date('Y'))
                    ->markAsRequired()
                    ->rules([
                        'required',
                        'integer',
                        'min:2020',
                        'max:'.date('Y'),
                    ])
                    ->validationMessages([
                        'required' => 'Tahun wajib diisi.',
                        'integer' => 'Tahun harus berupa angka.',
                        'min' => 'Tahun minimal 2020.',
                        'max' => 'Tahun tidak boleh lebih dari tahun sekarang.',
                    ]),

                Select::make('semester')
                    ->label('Semester')
                    ->options([
                        1 => 'Semester 1',
                        2 => 'Semester 2',
                    ])
                    ->placeholder('Pilih Semester')
                    ->markAsRequired()
                    ->rules(['required', 'in:1,2'])
                    ->validationMessages([
                        'required' => 'Semester wajib dipilih.',
                        'in' => 'Semester tidak valid.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_skpd')
                    ->label('Nama SKPD')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),

                TextColumn::make('semester')
                    ->label('Semester')
                    ->sortable(),

                TextColumn::make('persentase_tl')
                    ->label('Persentase TL (%)')
                    ->sortable()
                    ->badge()
                    ->color(function ($record) {
                        if ($record->persentase_tl >= 80) {
                            return 'success';
                        } elseif ($record->persentase_tl >= 60) {
                            return 'warning';
                        }

                        return 'danger';
                    })
                    ->formatStateUsing(function ($state) {
                        return number_format($state, 2, ',', '.').' %';
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()

                    ->label('Hapus Terpilih')
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus')
                    ->modalDescription('Apakah kamu yakin ingin menghapus data yang dipilih? Tindakan ini tidak bisa dibatalkan.')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(
                        TlJabar::distinct()
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

            ->filtersFormColumns(2)
            ->filtersLayout(Tables\Enums\FiltersLayout::Dropdown)
            ->defaultSort('tahun', 'desc')
            ->defaultSort('semester', 'desc')
            ->defaultSort('persentase_tl', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTlJabars::route('/'),
            'edit' => Pages\EditTlJabar::route('/{record}/edit'),
        ];
    }
}
