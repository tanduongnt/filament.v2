<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Tables;
use App\Models\System;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\SystemResource\Pages;
use SevendaysDigital\FilamentNestedResources\NestedResource;

class SystemResource extends NestedResource
{
    protected static ?string $model = System::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'systems';

    //protected static ?string $pluralModelLabel = 'Hệ thống';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function getParent(): string
    {
        return ProjectResource::class;
    }

    public static function getPluralModelLabel(): string
    {
        return 'Hệ thống';
    }

    public static function getModelLabel(): string
    {
        return 'Hệ thống';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->relationship('project', 'name'),
                TextInput::make('name')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord),
                TextInput::make('sort')
                    ->nullable()
                    ->numeric(),
                Select::make('technicians')
                    ->relationship('technicians', 'name')
                    ->multiple()
                    ->label('Kỹ thuật viên'),
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
                Tables\Actions\ViewAction::make(),
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
            'view' => Pages\ViewSystem::route('/{record}'),
            'edit' => Pages\EditSystem::route('/{record}/edit'),
        ];
    }
}
