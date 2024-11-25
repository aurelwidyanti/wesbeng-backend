<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Locations';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Location Details')
                    ->description('Manage location information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Location Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter location name')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull()
                            ->placeholder('Provide a brief description'),

                        Forms\Components\Select::make('category')
                            ->label('Location Category')
                            ->required()
                            ->options([
                                'organic' => 'Organik',
                                'non-organic' => 'Non-Organik', 
                                'B3' => 'Bahan Berbahaya & Beracun'
                            ])
                            ->searchable(),

                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->required()
                                    ->numeric()
                                    ->rules(['between:-90,90'])
                                    ->placeholder('e.g., -6.200000'),

                                Forms\Components\TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->required()
                                    ->numeric()
                                    ->rules(['between:-180,180'])
                                    ->placeholder('e.g., 106.816666')
                            ])->columns(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'organic' => 'success',
                        'non-organic' => 'warning',
                        'B3' => 'danger',
                        default => 'gray'
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description),
                Tables\Columns\TextColumn::make('coordinates')
                    ->label('Coordinates')
                    ->getStateUsing(fn ($record) => sprintf('%.6f, %.6f', $record->latitude, $record->longitude))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Filter by Category')
                    ->options([
                        'organic' => 'Organik',
                        'non-organic' => 'Non-Organik', 
                        'B3' => 'Bahan Berbahaya & Beracun'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}