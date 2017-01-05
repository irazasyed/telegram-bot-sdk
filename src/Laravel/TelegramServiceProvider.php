<?php

namespace Telegram\Bot\Laravel;

use Telegram\Bot\Api;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container as Application;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * Class TelegramServiceProvider.
 */
class TelegramServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Holds path to Config File.
     *
     * @var string
     */
    protected $config_filepath;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->setupConfig($this->app);
    }
    
    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
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
        $this->registerTelegram($this->app);
    }

    /**
     * Initialize Telegram Bot SDK Library with Default Config.
     *
     * @param Application $app
     */
    protected function registerTelegram(Application $app)
    {
        $app->singleton(Api::class, function ($app) {
            $config = $app['config'];

            $telegram = new Api(
                $config->get('telegram.bot_token', false),
                $config->get('telegram.async_requests', false),
                $config->get('telegram.http_client_handler', null)
            );

            // Register Commands
            $telegram->addCommands($config->get('telegram.commands', []));

            // Check if DI needs to be enabled for Commands
            if ($config->get('telegram.inject_command_dependencies', false)) {
                $telegram->setContainer($app);
            }

            return $telegram;
        });

        $app->alias(Api::class, 'telegram');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['telegram', Api::class];
    }
}
