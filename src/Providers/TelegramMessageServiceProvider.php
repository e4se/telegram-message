<?php

namespace E4se\TelegramMessage\Providers;

use E4se\TelegramMessage\Formatter\MessageFormatterHTML;
use Illuminate\Support\ServiceProvider;

class TelegramMessageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('MessageFormatter', function () {
            return new MessageFormatterHTML;
        });
    }

    public function boot()
    {
        //
    }
}
