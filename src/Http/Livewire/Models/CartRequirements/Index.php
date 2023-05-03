<?php

namespace Astrogoat\GoLoadUp\Http\Livewire\Models\CartRequirements;

use Astrogoat\GoLoadUp\Models\CartRequirement;
use Helix\Lego\Http\Livewire\Models\Index as BaseIndex;

class Index extends BaseIndex
{
    public function model(): string
    {
        return CartRequirement::class;
    }

    public function columns(): array
    {
        return [
            'title' => 'Service',
        ];
    }

    public function mainSearchColumn(): string|false
    {
        return 'title';
    }

    public function render()
    {
        return view('go-load-up::models.cart-requirements.index', [
            'models' => $this->getModels(),
        ])->extends('lego::layouts.lego')->section('content');
    }
}
