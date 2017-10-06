<?php

namespace Telegram\Bot\Laravel;

use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Laravel\Artisan\WebhookCommand;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Contracts\Container\Container as Application;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * Class TelegramServiceProvider.
 */
class TelegramServiceProvider extends ServiceProvider
{
    /** @var bool Indicates if loading of the provider is deferred. */
    protected $defer = true;

    /** Boot the service provider. */
    public function boot()
    {
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     */
    protected function setupConfig(Application $app)
    {
        $source = __DIR__.'/config/telegram.php';

        if ($app instanceof LaravelApplication && $app->runningInConsole()) {
            $this->publishes([$source => config_path('telegram.php')]);
        } elseif ($app instanceof LumenApplication) {
            $app->configure('telegram');
        }

        $this->mergeConfigFrom($source, 'telegram');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerManager($this->app);
        $this->registerBindings($this->app);
        $this->commands('telegram.bot.commands.webhook');
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     */
    protected function registerManager(Application $app)
    {
        $app->singleton('telegram', function ($app) {
            $config = app('config')->get('telegram');

            return (new BotsManager($config))->setContainer($app);
        });

        $app->alias('telegram', BotsManager::class);
    }

    /**
     * Register the bindings.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     */
    protected function registerBindings(Application $app)
    {
        $app->bind('telegram.bot', function ($app) {
            $manager = $app['telegram'];

            return $manager->bot();
        });

        $app->bind('telegram.bot.commands.webhook', WebhookCommand::class);

        $app->alias('telegram.bot', Api::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['telegram', 'telegram.bot', BotsManager::class, Api::class];
    }
}
