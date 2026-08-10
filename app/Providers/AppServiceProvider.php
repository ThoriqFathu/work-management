<?php

namespace App\Providers;

use App\Services\Telegram\Commands\CreateRequestCommand;
use App\Services\Telegram\Commands\HelpCommand;
use App\Services\Telegram\Commands\InfoRequesterCommand;
use App\Services\Telegram\Commands\InfoWorkSessionCommand;
use App\Services\Telegram\Commands\RecordActivityCommand;
use App\Services\Telegram\Commands\TelegramCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            InfoRequesterCommand::class,
            CreateRequestCommand::class,
            RecordActivityCommand::class,
            InfoWorkSessionCommand::class,
            HelpCommand::class,
        ], 'telegram.commands');

        $this->app->singleton(
            \App\Services\Telegram\Commands\TelegramCommandRegistry::class,
            function ($app) {
                return new \App\Services\Telegram\Commands\TelegramCommandRegistry(
                    $app->tagged('telegram.commands')
                );
            }
        );

        $this->app->singleton(
            \App\Services\Telegram\Commands\TelegramCommandRouter::class,
            function ($app) {
                return new \App\Services\Telegram\Commands\TelegramCommandRouter(
                    $app->make(
                        \App\Services\Telegram\Commands\TelegramCommandRegistry::class
                    )
                );
            }
        );
    }

    public function boot(): void
    {
        //
    }
}