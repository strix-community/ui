<?php

namespace Strix\Ui;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Strix-community\Ui\Ui
 */
class UiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ui';
    }
}
