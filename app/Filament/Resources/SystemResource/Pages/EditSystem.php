<?php

namespace App\Filament\Resources\SystemResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SystemResource;
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

class EditSystem extends EditRecord
{
    use NestedPage;

    protected static string $resource = SystemResource::class;

    protected static ?string $title = 'Cập nhật hệ thống';

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
