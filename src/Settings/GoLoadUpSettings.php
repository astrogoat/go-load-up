<?php

namespace Astrogoat\GoLoadUp\Settings;

use Astrogoat\GoLoadUp\Actions\GoLoadUpAction;
use Helix\Lego\Settings\AppSettings;
use Illuminate\Validation\Rule;

class GoLoadUpSettings extends AppSettings
{
    // public string $url;

    public function rules(): array
    {
        return [
            // 'url' => Rule::requiredIf($this->enabled === true),
        ];
    }

    // protected static array $actions = [
    //     GoLoadUpAction::class,
    // ];

    // public static function encrypted(): array
    // {
    //     return ['access_token'];
    // }

    public function description(): string
    {
        return 'Interact with GoLoadUp.';
    }

    public static function group(): string
    {
        return 'go-load-up';
    }
}
