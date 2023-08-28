<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Livewire\Event;
use Filament\Tables;
use App\Models\System;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\SystemResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SystemResource\RelationManagers;
use SevendaysDigital\FilamentNestedResources\NestedResource;
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;
use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;

class SystemResource extends NestedResource
{
    protected static ?string $model = System::class;

    protected static ?string $slug = 'systems';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getParent(): string
    {
        return ProjectResource::class;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->relationship('project', 'name'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug'),
                TextInput::make('sort')
                    ->nullable()
                    ->numeric(),
                TextInput::make('description')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                IconColumn::make('active')
                    ->boolean()
            ])
            ->filters([
                SelectFilter::make('active')
                    ->options([
                        '1' => 'acvite',
                        '0' => 'unacvite',
                    ]),
                SelectFilter::make('name')
                    ->options(System::all()->pluck('name'))
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSystems::route('/'),
            'create' => Pages\CreateSystem::route('/create'),
            'edit' => Pages\EditSystem::route('/{record}/edit'),
        ];
    }
}
