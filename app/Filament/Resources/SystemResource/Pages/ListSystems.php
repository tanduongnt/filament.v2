<?php

namespace App\Filament\Resources\SystemResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\SystemResource;
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

class ListSystems extends ListRecords
{
    use NestedPage;

    protected static string $resource = SystemResource::class;

    protected static ?string $title = 'Danh sách hệ thống';

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
