<?php

namespace LaravelBoilerplates\BaseBoilerplate\Facades;

use LaravelBoilerplates\BaseBoilerplate\Base;
use Illuminate\Support\Facades\Facade;

class BaseFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Base::class;
    }
}
