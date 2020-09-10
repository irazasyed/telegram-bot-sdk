<?php

namespace Telegram\Bot\Laravel;

use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Laravel\Artisan\WebhookCommand;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * Class TelegramServiceProvider.
 */
class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();
        $this->offerPublishing();
        $this->registerBindings();
        $this->registerCommands();
    }

    /**
     * Setup the configuration.
     */
    protected function configure()
    {
        $this->mergeConfigFrom(__DIR__.'/config/telegram.php', 'telegram');
    }

    /**
     * Setup the resource publishing groups.
     */
    protected function offerPublishing()
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
    protected function registerBindings()
    {
        $this->app->bind(BotsManager::class, static function ($app) {
            return (new BotsManager(config('telegram')))->setContainer($app);
        });
        $this->app->alias(BotsManager::class, 'telegram');

        $this->app->bind(Api::class, static function ($app) {
            return $app[BotsManager::class]->bot();
        });
        $this->app->alias(Api::class, 'telegram.bot');
    }

    /**
     * Register the Artisan commands.
     */
    protected function registerCommands()
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
