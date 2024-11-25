<?php

namespace App\Filament\Resources\TrashResource\Pages;

use App\Filament\Resources\TrashResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrash extends EditRecord
{
    protected static string $resource = TrashResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
