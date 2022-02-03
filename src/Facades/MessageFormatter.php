<?php

namespace E4se\TelegramMessage\Facades;

use Illuminate\Support\Facades\Facade;

class MessageFormatter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'MessageFormatter';
    }
}
