<?php

namespace App\Filament\Resources\SystemResource\Pages;

use App\Filament\Resources\SystemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSystem extends ViewRecord
{
    protected static string $resource = SystemResource::class;

    protected static ?string $title = 'Chi tiết hệ thống';
}
