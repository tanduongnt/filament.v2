<?php

namespace App\Filament\Resources\SystemResource\Pages;

use Filament\Pages\Actions;
use App\Filament\Resources\SystemResource;
use Filament\Resources\Pages\CreateRecord;
use SevendaysDigital\FilamentNestedResources\ResourcePages\NestedPage;

class CreateSystem extends CreateRecord
{
    use NestedPage;

    protected static string $resource = SystemResource::class;

    protected static ?string $title = 'Thêm mới hệ thống';
}
