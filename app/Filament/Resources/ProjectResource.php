<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProjectResource\Pages;
use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('slug'),
                        TextInput::make('sort')
                            ->nullable()
                            ->numeric(),
                        TextInput::make('address')
                            ->required(),
                        TextInput::make('phone')
                            ->nullable(),
                        RichEditor::make('description')
                            ->nullable(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ChildResourceLink::make(SystemResource::class),
                TextColumn::make('name')->limit(50)->sortable()->searchable(),
                TextColumn::make('systems_count')->counts('systems'),
                IconColumn::make('active')->boolean()
            ])
            ->filters([
                SelectFilter::make('active')
                    ->options([
                        '1' => 'acvite',
                        '0' => 'unacvite',
                    ]),
                SelectFilter::make('name')
                    ->options(Project::all()->pluck('name'))
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
