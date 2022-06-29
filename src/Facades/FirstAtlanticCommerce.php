<?php

/*
 * This file is part of the Laravel First Atlantic Commerce package.
 *
 * (c) Jordan Bain <jordanbaindev961@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jordanbain\FirstAtlanticCommerce\Facades;

use Illuminate\Support\Facades\Facade;

class FirstAtlanticCommerce extends Facade
{
    /**
     * Get the registered name of the component
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-first-atlantic-commerce';
    }
}
