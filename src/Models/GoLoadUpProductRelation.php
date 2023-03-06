<?php

namespace Astrogoat\GoLoadUp\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model as LegoModel;

class GoLoadUpProductRelation extends LegoModel
{
    protected $table = 'go_load_up_shopify_product';

    public static function icon(): string
    {
        return Icon::DOCUMENT;
    }
}
