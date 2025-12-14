<?php

namespace App\Filament\Resources;

use App\Filament\Resources\McpAreaResource\Pages;
use App\Models\McpArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class McpAreaResource extends Resource
{
    protected static ?string $model = McpArea::class;

    protected static ?string $navigationGroup = 'MCSP KPK';

    protected static ?string $pluralModelLabel = 'Area MCSP KPK';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Area MCSP KPK';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Area MCSP KPK')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')->label('Area MCSP KPK')->searchable(),

            ])

            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah Area MCSP KPK'),

            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMcpAreas::route('/'),
        ];
    }
}
