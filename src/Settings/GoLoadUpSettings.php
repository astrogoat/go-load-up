<?php

namespace Astrogoat\GoLoadUp\Settings;

use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class GoLoadUpSettings extends AppSettings
{
    public string $white_glove_shopify_product_ID;

    public function rules(): array
    {
        return [
             'white_glove_shopify_product_ID' => Rule::requiredIf($this->enabled === true),
        ];
    }

    public function description(): string
    {
        return 'Interact with GoLoadUp.';
    }

    public static function group(): string
    {
        return 'go-load-up';
    }
}
