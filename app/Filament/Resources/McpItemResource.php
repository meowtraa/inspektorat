<?php

namespace App\Filament\Resources;

use App\Filament\Resources\McpItemResource\Pages;
use App\Models\McpArea;
use App\Models\McpItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class McpItemResource extends Resource
{
    protected static ?string $model = McpItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';

    protected static ?string $pluralModelLabel = 'Indikator MCSP KPK';

    protected static ?string $navigationLabel = 'Indikator MCSP KPK';

    protected static ?string $navigationGroup = 'MCSP KPK';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Select::make('area_id')
                ->label('Area MCSP KPK')
                ->options(McpArea::pluck('name', 'id'))
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('year')
                ->label('Tahun')
                ->numeric()
                ->default(now()->year)
                ->required(),

            Forms\Components\TextInput::make('code')
                ->label('Kode (opsional)')
                ->maxLength(255),

            Forms\Components\TextInput::make('name')
                ->label('Indikator')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_complete')
                ->label('Status')
                ->inline(false),

            Forms\Components\Textarea::make('notes')
                ->label('Catatan')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('area.name')
                    ->label('Area')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Indikator')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\IconColumn::make('is_complete')
                    ->label('Status')
                    ->boolean()
                    ->action(fn (McpItem $record) => $record->update([
                        'is_complete' => ! $record->is_complete,
                    ])
                    ),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([
                Tables\Filters\SelectFilter::make('year')
                    ->label('Tahun')
                    ->options(
                        McpItem::select('year')->distinct()->pluck('year', 'year')
                    ),
            ])

            ->actions([
                Tables\Actions\EditAction::make()->modalHeading('Ubah Indikator'),

            ])

            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMcpItems::route('/'),
        ];
    }
}
