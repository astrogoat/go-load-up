<?php

namespace Astrogoat\GoLoadUp\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model as LegoModel;

class Service extends LegoModel
{
    protected $table = 'go_load_up_services';

    protected $casts = [
        'product_variant_ids' => 'array',
    ];

    public static function icon(): string
    {
        return Icon::DOCUMENT;
    }

    public function getDisplayKeyName()
    {
        return 'label';
    }
}
