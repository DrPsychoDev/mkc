<?php

namespace App\Filament\Attendance\Resources\AttendanceResource\Pages;

use App\Filament\Attendance\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
