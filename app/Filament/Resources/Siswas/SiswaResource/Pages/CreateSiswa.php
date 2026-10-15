<?php

namespace App\Filament\Resources\Siswas\SiswaResource\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Memastikan user_id terisi otomatis
        $data['user_id'] = auth()->id() ?? 1;

        return $data;
    }
}