<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected static ?string $title = 'Danh sách dự án';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
