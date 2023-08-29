<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProjectResource\Pages;
use SevendaysDigital\FilamentNestedResources\Columns\ChildResourceLink;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getPluralModelLabel(): string
    {
        return 'Dự án';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                TextInput::make('name')
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    })
                    ->required()
                    ->label('Tên'),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(fn (Page $livewire) => $livewire instanceof CreateRecord),
                TextInput::make('sort')
                    ->nullable()
                    ->numeric()
                    ->label('Sắp xếp'),
                TextInput::make('address')
                    ->required()
                    ->label('Địa chỉ'),
                TextInput::make('phone')
                    ->nullable()
                    ->label('Điện thoại'),
                Select::make('user_id')
                    ->relationship('managers', 'name')
                    ->multiple()
                    ->label('Kỹ sư trưởng'),
                RichEditor::make('description')
                    ->nullable()
                    ->label('Mô tả'),
                Toggle::make('active')->label('Theo dõi'),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Tên')->sortable()->searchable(),
                ChildResourceLink::make(SystemResource::class),
                TextColumn::make('managers.name')->label('Kỹ sư trưởng'),
                IconColumn::make('active')->boolean()->label('Vận hành'),
            ])
            ->filters([
                SelectFilter::make('Theo dõi')
                    ->options([
                        '1' => 'acvite',
                        '0' => 'unacvite',
                    ])->attribute('active'),
                SelectFilter::make('name')
                    ->label('Dự án')
                    ->options(Project::all()->pluck('name'))
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
