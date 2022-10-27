<?php

namespace Astrogoat\GoLoadUp;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Astrogoat\GoLoadUp\GoLoadUp
 */
class GoLoadUpFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'go-load-up';
    }
}
