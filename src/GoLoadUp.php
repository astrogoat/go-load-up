<?php

namespace Astrogoat\GoLoadUp;

use Astrogoat\GoLoadUp\Models\ZipCode;

class GoLoadUp
{
    static public function verifyZipCode($zipCode) : ZipCode|null
    {
     return ZipCode::all()->where('zip', $zipCode)->first();
    }
}
