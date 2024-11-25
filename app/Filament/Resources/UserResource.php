<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'User Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Details')
                    ->description('Manage user account information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Full Name'),

                        Forms\Components\TextInput::make('username')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->default(null),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255)
                            ->default(null),

                        Forms\Components\Select::make('role')
                            ->options([
                                'admin' => 'Administrator',
                                'user' => 'User',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(255)
                            ->hiddenOn('edit')
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state)),

                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verification')
                            ->required(false)
                            ->default(null) 
                            ->hiddenOn('create') 
                            ->dehydrateStateUsing(fn ($state) => $state ? $state : null),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('role')
                    ->colors([
                        'danger' => 'admin',
                        'primary' => 'user',
                    ]),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime() 
                    ->sortable()
                    ->label('Email Verification Date'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Administrator',
                        'user' => 'User',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
