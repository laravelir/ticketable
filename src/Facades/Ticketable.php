<?php

namespace Laravelir\Ticketable\Facades;

use Illuminate\Support\Facades\Facade;

class Ticketable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ticketable';
    }
}
