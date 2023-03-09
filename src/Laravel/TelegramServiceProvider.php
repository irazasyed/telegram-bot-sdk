<?php

namespace Telegram\Bot\Laravel;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Laravel\Artisan\WebhookCommand;

/**
 * Class TelegramServiceProvider.
 */
final class TelegramServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->configure();
        $this->offerPublishing();
        $this->registerBindings();
        $this->registerCommands();
    }

    /**
     * Setup the configuration.
     */
    private function configure(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/telegram.php', 'telegram');
    }

    /**
     * Setup the resource publishing groups.
     */
    private function offerPublishing(): void
    {
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/telegram.php' => config_path('telegram.php'),
            ], 'telegram-config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('telegram');
        }
    }

    /**
     * Register bindings in the container.
     */
    private function registerBindings(): void
    {
        $this->app->singleton(BotsManager::class, static fn ($app): BotsManager => (new BotsManager(config('telegram')))->setContainer($app));
        $this->app->alias(BotsManager::class, 'telegram');

        $this->app->bind(Api::class, static fn ($app) => $app[BotsManager::class]->bot());
        $this->app->alias(Api::class, 'telegram.bot');
    }

    /**
     * Register the Artisan commands.
     */
    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                WebhookCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [BotsManager::class, Api::class, 'telegram', 'telegram.bot'];
    }
}
