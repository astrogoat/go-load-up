<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\Models\ZipCodes;

use Astrogoat\GoLoadUp\Models\ZipCode;
use Helix\Lego\Http\Livewire\Models\Index as BaseIndex;

class Index extends BaseIndex
{
    public function model(): string
    {
        return ZipCode::class;
    }

    public function columns(): array
    {
        return [
            'zip' => 'Zip',
            'name' => 'Name',
            'is_eligible' => 'Eligibility',
            'updated_at' => 'Last updated',
        ];
    }

    public function mainSearchColumn(): string|false
    {
        return 'zip';
    }

    public function render()
    {
        return view('go-load-up::models.zip-codes.index', [
            'models' => $this->getModels(),
        ])->extends('lego::layouts.lego')->section('content');
    }
}
