<?php

namespace App\Filament\Resources;

use App\Filament\Resources\McpAreaScoreResource\Pages;
use App\Models\McpArea;
use App\Models\McpAreaScore;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\DB;

class McpAreaScoreResource extends Resource
{
    protected static ?string $model = McpAreaScore::class;

       protected static ?string $navigationGroup = 'MCSP KPK';


    protected static ?string $navigationLabel = 'Nilai MCSP KPK';

    protected static ?string $pluralModelLabel = 'Nilai MCSP KPK per Area';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    /* ======================================================
     | FORM SCHEMA - CREATE (BATCH INPUT)
     ====================================================== */
    protected static function createSchema(): array
    {
        return [

            Forms\Components\Select::make('tahun')
                ->label('Tahun')
                ->options(
                    collect(range(now()->year, 2020))
                        ->mapWithKeys(fn ($y) => [$y => $y])
                        ->toArray()
                )
                ->required(),

            Forms\Components\Repeater::make('scores')
                ->label('Nilai per Area MCSP KPK')
                ->schema([

                    Forms\Components\Select::make('mcp_area_id')
                        ->label('Area MCSP KPK')
                        ->options(
                            McpArea::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')
                        )
                        ->required(),

                    Forms\Components\TextInput::make('bobot')
                        ->label('Bobot')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->required(),

                    Forms\Components\TextInput::make('persentase')
                        ->label('Nilai')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->default(0)
                        ->required(),
                ])
                ->columns(3)
                ->required(),
        ];
    }

    /* ======================================================
     | FORM SCHEMA - EDIT (SINGLE RECORD)
     ====================================================== */
    protected static function editSchema(): array
    {
        return [

            Forms\Components\Select::make('mcp_area_id')
                ->label('Area MCSP KPK')
                ->options(
                    McpArea::query()
                        ->orderBy('name')
                        ->pluck('name', 'id')
                )
                ->disabled()
                ->required(),

            Forms\Components\TextInput::make('tahun')
                ->label('Tahun')
                ->disabled()
                ->required(),

            Forms\Components\TextInput::make('bobot')
                ->label('Bobot (%)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),

            Forms\Components\TextInput::make('persentase')
                ->label('Nilai')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),
        ];
    }

    /* ======================================================
     | TABLE
     ====================================================== */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('area.name')
                    ->label('Area MCSP KPK')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),

                TextColumn::make('bobot')
                    ->label('Bobot')
                    ->sortable()
                    ->formatStateUsing(
                        fn ($state) => number_format($state, 2, ',', '.') . ' %'
                    ),

                TextColumn::make('persentase')
                    ->label('Nilai')
                    ->badge()
                    ->sortable()
                    ->color(fn ($state) =>
                        $state >= 80
                            ? 'success'
                            : ($state >= 60 ? 'warning' : 'danger')
                    )
                    ->formatStateUsing(
                        fn ($state) => number_format($state, 2, ',', '.')
                    ),
            ])
            ->defaultSort('tahun', 'desc')
            ->filters([

                Tables\Filters\SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(
                        McpAreaScore::query()
                            ->select('tahun')
                            ->distinct()
                            ->orderByDesc('tahun')
                            ->pluck('tahun', 'tahun')
                    ),
            ])
            ->headerActions([

                /* ==================================================
                 | CREATE (BATCH INPUT VIA MODAL)
                 ================================================== */
                Tables\Actions\Action::make('input_mcp')
                    ->label('Input Nilai MCSP KPK')
                    ->icon('heroicon-o-plus-circle')
                    ->modalHeading('Input Nilai MCSP KPK per Area')
                    ->modalWidth('7xl')
                    ->form(fn () => self::createSchema())
                    ->action(function (array $data) {

                        DB::transaction(function () use ($data) {

                            foreach ($data['scores'] as $row) {
                                McpAreaScore::updateOrCreate(
                                    [
                                        'mcp_area_id' => $row['mcp_area_id'],
                                        'tahun' => $data['tahun'],
                                    ],
                                    [
                                        'bobot' => $row['bobot'],
                                        'persentase' => $row['persentase'],
                                    ]
                                );
                            }
                        });
                    }),
            ])
            ->actions([

                /* ==================================================
                 | EDIT (SINGLE RECORD)
                 ================================================== */
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Nilai MCSP KPK')
                    ->modalWidth('md')
                    ->form(fn () => self::editSchema()),
            ])
            ->bulkActions([

                Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation(),
            ]);
    }

    /* ======================================================
     | PAGES
     ====================================================== */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMcpAreaScores::route('/'),
        ];
    }
}
