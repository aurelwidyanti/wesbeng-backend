<?php

namespace App\Filament\Resources\EducationalContentResource\Pages;

use App\Filament\Resources\EducationalContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEducationalContents extends ListRecords
{
    protected static string $resource = EducationalContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
