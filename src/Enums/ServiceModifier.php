<?php

namespace Astrogoat\GoLoadUp\Enums;

enum ServiceModifier: string
{
    case CALIFORNIA = 'California';

    public function code(): string
    {
        return match($this)
        {
            self::CALIFORNIA => 0,
        };
    }

    public function label(): string
    {
        return match($this)
        {
            self::CALIFORNIA => 'California',
        };
    }
}
