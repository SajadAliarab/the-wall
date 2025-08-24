<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Attachment;
use App\Models\Post;
use App\Models\States\Post\PostApprovedStatus;
use App\Models\States\Post\PostPendingStatus;
use App\Models\States\Post\PostRejectedStatus;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->disabled(),
                Forms\Components\Textarea::make('description')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('price')
                    ->disabled()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->disabled(),
                Repeater::make('attachments')
                    ->relationship('attachments')
                    ->schema([
                        Placeholder::make('attachments')
                            ->content(function (Attachment $record): HtmlString {
                                return new HtmlString('<img src="' . $record->url() . '" style="max-width: auto; max-height: auto;" />');
                            }),
                    ])
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        PostPendingStatus::$name => 'Pending',
                        PostApprovedStatus::$name => 'Approved',
                        PostRejectedStatus::$name => 'Rejected',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
//                    ->color(fn (Post $record): string => match ($record->status) {
//                        PostPendingStatus::$name => 'warning',
//                        PostApprovedStatus::$name => 'success',
//                        PostRejectedStatus::$name => 'danger',
//                    })
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        PostPendingStatus::$name => 'Pending',
                        PostApprovedStatus::$name => 'Approved',
                        PostRejectedStatus::$name => 'Rejected',
                    ])
                    ->default(PostPendingStatus::$name),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Check')
                    ->icon('heroicon-o-check'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return parent::canDelete($record);
    }
}
