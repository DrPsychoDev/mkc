<?php

namespace App\Filament\Admin\Resources\UsersResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
