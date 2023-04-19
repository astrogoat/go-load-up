<?php

namespace Astrogoat\GoLoadUp\Models;

use Helix\Fabrick\Icon;
use Helix\Lego\Models\Model as LegoModel;

class CheckboxCombination extends LegoModel
{
    protected $table = 'go_load_up_checkbox_combinations';

    public static function icon(): string
    {
        return Icon::DOCUMENT;
    }

    public function getDisplayKeyName()
    {
        return 'label';
    }
}
