<?php

namespace Astrogoat\GoLoadUp;

use Astrogoat\GoLoadUp\Models\ZipCode;

class GoLoadUp
{
    public static function getZipCodeModel($zipCode): ZipCode|null
    {
        return ZipCode::all()->where('zip', $zipCode)->first();
    }
}
