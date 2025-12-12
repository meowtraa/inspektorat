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

    protected static ?string $navigationGroup = 'MCP KPK';

    protected static ?string $pluralModelLabel = 'Area MCP KPK';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Area MCP KPK';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Area MCP KPK')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')->label('Area MCP KPK')->searchable(),

            ])

            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah Area MCP KPK'),

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
