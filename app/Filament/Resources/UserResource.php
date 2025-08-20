<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->regex('/^.+@.+$/i')
                    ->disabled(fn (string $context): bool => $context === 'edit'),
                TextInput::make('password')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->password()
                    ->rules([
                        Password::min(8)
                            ->letters()
                            ->numbers()
                            ->symbols()
                            ->mixedCase(),
                    ])
                    ->confirmed()
                    ->helperText(fn (string $context): ?string => $context === 'edit' ? 'If the password field leaves empty, it would not change!' : null)
                    ->nullable(fn (string $context): bool => $context === 'edit')
                    ->dehydrated(fn (mixed $state): bool => filled($state)),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->nullable(fn (string $context): bool => $context === 'edit')
                    ->dehydrated(false),
                Toggle::make('is_admin')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user'),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),
                CheckboxColumn::make('is_admin'),
            ])
            ->filters([
                Filter::make('is_admin')
                    ->query(fn (Builder $query): Builder => $query->where('is_admin', true))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
