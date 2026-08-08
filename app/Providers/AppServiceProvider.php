<?php

namespace App\Providers;

use App\Services\Telegram\Commands\CreateRequestCommand;
use App\Services\Telegram\Commands\InfoRequesterCommand;
use App\Services\Telegram\Commands\TelegramCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            InfoRequesterCommand::class,
            CreateRequestCommand::class,
        ], 'telegram.commands');

        $this->app->singleton(
            \App\Services\Telegram\Commands\TelegramCommandRouter::class,
            function ($app) {
                return new \App\Services\Telegram\Commands\TelegramCommandRouter(
                    $app->tagged('telegram.commands')
                );
            }
        );
    }

    public function boot(): void
    {
        //
    }
}