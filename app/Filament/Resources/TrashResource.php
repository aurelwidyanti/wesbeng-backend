<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrashResource\Pages;
use App\Models\Trash;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class TrashResource extends Resource
{
    protected static ?string $model = Trash::class;

    protected static ?string $navigationIcon = 'heroicon-o-trash';

    protected static ?string $navigationLabel = 'Trash Schedule';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Waste Details')
                    ->description('Manage waste collection information')
                    ->schema([
                        Forms\Components\Select::make('location_id')
                            ->relationship('location', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Collection Location'),

                        Forms\Components\Select::make('type')
                            ->options([
                                'organic' => 'Organik',
                                'anorganic' => 'Anorganik',
                                'B3' => 'Bahan Berbahaya & Beracun'
                            ])
                            ->required()
                            ->label('Waste Type'),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('volume')
                                    ->numeric()
                                    ->required()
                                    ->suffix('m³')
                                    ->minValue(0)
                                    ->step(0.1),

                                Forms\Components\TextInput::make('weight')
                                    ->numeric()
                                    ->required()
                                    ->suffix('kg')
                                    ->minValue(0)
                                    ->step(0.1)
                            ])->columns(2),

                        Forms\Components\DatePicker::make('collection_date')
                            ->required()
                            ->native(false),

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'collected' => 'Dikumpulkan',
                                'processed' => 'Diproses'
                            ])
                            ->default('pending')
                            ->label('Status')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('location.name')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'organic' => 'success',
                        'anorganic' => 'warning',
                        'B3' => 'danger',
                        default => 'gray'
                    }),
                Tables\Columns\TextColumn::make('volume')
                    ->suffix(' m³')
                    ->sortable(),
                Tables\Columns\TextColumn::make('weight')
                    ->suffix(' kg')
                    ->sortable(),
                Tables\Columns\TextColumn::make('collection_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'collected',
                        'primary' => 'processed'
                    ])
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'organic' => 'Organik',
                        'anorganic' => 'Anorganik',
                        'B3' => 'Bahan Berbahaya & Beracun'
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'collected' => 'Dikumpulkan',
                        'processed' => 'Diproses'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('collection_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrashes::route('/'),
            'create' => Pages\CreateTrash::route('/create'),
            'edit' => Pages\EditTrash::route('/{record}/edit'),
        ];
    }
}
