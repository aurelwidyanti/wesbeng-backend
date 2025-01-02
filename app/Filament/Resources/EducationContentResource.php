<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationContentResource\Pages;
use App\Models\EducationContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;

class EducationContentResource extends Resource
{
    protected static ?string $model = EducationContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Education Contents';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Content Details')
                    ->description('Manage education content details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter content title')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('content')
                            ->label('Content')
                            ->rows(5)
                            ->required()
                            ->placeholder('Provide the main content')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image')
                            ->label('Image')
                            ->disk('public')
                            ->directory('education_contents/images')
                            ->visibility('public')
                            ->image()
                            ->required(),


                        Forms\Components\Select::make('category')
                            ->label('Category')
                            ->required()
                            ->options([
                                'organic' => 'Organik',
                                'anorganic' => 'Anorganik', 
                                'B3' => 'Bahan Berbahaya & Beracun',
                            ])
                            ->searchable(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public') // Pastikan ini sudah menunjuk ke disk 'public'
                    ->getStateUsing(fn($record) => asset('storage/' . $record->image)) // Bangun URL gambar dengan benar
                    ->height(50)
                    ->width(50),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'organic' => 'success',
                        'anorganic' => 'warning',
                        'B3' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Filter by Category')
                    ->options([
                        'organic' => 'Organik',
                        'anorganic' => 'Anorganik', 
                        'B3' => 'Bahan Berbahaya & Beracun',
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
            'index' => Pages\ListEducationContents::route('/'),
            'create' => Pages\CreateEducationContent::route('/create'),
            'edit' => Pages\EditEducationContent::route('/{record}/edit'),
        ];
    }
}
