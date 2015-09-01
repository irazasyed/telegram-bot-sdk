<?php

namespace Irazasyed\Telegram\Laravel;

use Irazasyed\Telegram\Telegram;
use Illuminate\Support\ServiceProvider;

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
        $this->publishes([
            $this->config_filepath => config_path('telegram.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerTelegram();

        $this->config_filepath = __DIR__.'/config/telegram.php';

        $this->mergeConfigFrom($this->config_filepath, 'telegram');
    }

    /**
     * Initialize Telegram Bot SDK Library with Default Config.
     */
    public function registerTelegram()
    {
        $this->app->singleton('telegram', function ($app) {
            $config = $app['config'];

            $telegram = new Telegram(
                $config->get('telegram.bot_token', false),
                $config->get('telegram.async_requests', false),
                $config->get('telegram.http_client_handler', null)
            );

            // Register Commands
            $telegram->addCommands($config->get('telegram.commands'), []);

            return $telegram;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['telegram'];
    }
}
