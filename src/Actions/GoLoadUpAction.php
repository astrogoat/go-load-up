<?php

namespace Astrogoat\GoLoadUp\Actions;

use Helix\Lego\Apps\Actions\Action;

class GoLoadUpAction extends Action
{
    public static function actionName(): string
    {
        return 'GoLoadUp action name';
    }

    public static function run(): mixed
    {
        return redirect()->back();
    }
}
