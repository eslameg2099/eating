<?php

namespace App\Support\Payment\Facades;

use Illuminate\Support\Facades\Facade;

class Cashier extends Facade
{
    /**
     * Get the registered name of the cashier manager.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'cashier';
    }
}