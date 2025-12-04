<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TlJabarResource\Pages;
use App\Models\TlJabar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TlJabarResource extends Resource
{
    protected static ?string $model = TlJabar::class;

    protected static ?string $navigationGroup = 'Tindak Lanjut';
    protected static ?string $navigationLabel = 'TL Jabar';
    protected static ?string $pluralModelLabel = 'Tindak Lanjut Jabar';
    protected static ?string $icon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_skpd')
                    ->label('Nama SKPD')
                    ->unique(ignoreRecord: true)
                    ->required(),

                TextInput::make('persentase_tl')
                    ->label('Persentase TL (%)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(0)
                    ->step(0.01)
                    ->required(),
                TextInput::make('tahun')
                    ->numeric()
                    ->minValue(2020) // boleh diubah
                    ->maxValue(date('Y'))
                    ->required(),

                Select::make('semester')
                    ->options([
                        1 => 'Semester 1',
                        2 => 'Semester 2',
                    ])
                    ->required(),
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

                TextColumn::make('persentase_tl')
                    ->label('Persentase TL (%)')
                    ->sortable(),
            ])
            ->defaultSort('persentase_tl', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTlJabars::route('/'),
            'create' => Pages\CreateTlJabar::route('/create'),
            'edit' => Pages\EditTlJabar::route('/{record}/edit'),
        ];
    }
}
