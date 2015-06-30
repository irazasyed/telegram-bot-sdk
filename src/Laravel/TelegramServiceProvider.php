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
     * Indicates if the package is loaded in Laravel 4.
     *
     * @var bool
     */
    protected $isLaravel4 = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if ($this->isLaravel4) {
            $this->package('irazasyed/laravel-telegram-bot', 'telegram');

            return;
        }

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

        if (method_exists($this, 'package')) {
            $this->isLaravel4 = true;

            return;
        }

        $this->config_filepath = realpath(__DIR__.'/config/telegram.php');

        $this->mergeConfigFrom($this->config_filepath, 'telegram');
    }

    /**
     * Initialize Telegram Bot SDK Library with Default Config.
     */
    public function registerTelegram()
    {
        $this->app->singleton('telegram', function ($app) {
            $packageNamespace = ($this->isLaravel4) ? 'telegram::telegram.' : 'telegram.';
            $config = $app['config'];

            $telegram = new Telegram(
                $config->get($packageNamespace.'bot_token', false),
                $config->get($packageNamespace.'async_requests', false),
                $config->get($packageNamespace.'http_client_handler', null)
            );

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