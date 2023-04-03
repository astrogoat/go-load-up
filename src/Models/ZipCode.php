<?php

namespace Astrogoat\GoLoadUp\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model as LegoModel;

class ZipCode extends LegoModel
{
    protected $table = 'go_load_up_serviceable_zip_codes';

    public static function icon(): string
    {
        return Icon::COLLECTION;
    }

    public function getDisplayKeyName()
    {
        return 'name';
    }
}
