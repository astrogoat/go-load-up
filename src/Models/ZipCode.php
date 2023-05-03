<?php

namespace Astrogoat\GoLoadUp\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model as LegoModel;

class ZipCode extends LegoModel
{
    protected $table = 'go_load_up_serviceable_zip_codes';

    protected $casts = [
        'is_california' => 'boolean',
        'is_eligible' => 'boolean',
    ];

    public static function icon(): string
    {
        return Icon::COLLECTION;
    }

    public function getDisplayKeyName()
    {
        return 'name';
    }

    public function isInCalifornia(): bool
    {
        return $this->is_california;
    }

    public function isEligible(): bool
    {
        return $this->is_eligible;
    }
}
