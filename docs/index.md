# Overview

## Introduction

> Telegram Bot API is an HTTP-based interface created for developers keen on building bots for Telegram.
> To learn how to create and set up a bot, please consult the [Introduction to Bots][telegram-bot] and [Bot FAQ](https://core.telegram.org/bots/faq) on official Telegram site.

### Telegram Bot API - PHP SDK

This is an Unofficial [Telegram Bot API][telegram-bot] SDK for **PHP** language. Lets you develop Telegram Bots easily! Supports Laravel out of the box.

Please review the official [documentation](https://core.telegram.org/bots/api) of [Telegram Bot API][telegram-bot] to understand the usage better.

# Requirements
* PHP 5.5+
* Composer
* Telegram Bot API Access Token - Talk to [@BotFather](https://core.telegram.org/bots#botfather) and generate one.
- Laravel 5 or Lumen Installation (Optional only if you want to use with either of these frameworks).

# Installation

The recommended way to install the SDK is with [Composer][composer]. Composer is a dependency management tool for PHP that allows you to declare the dependencies your project needs and installs them into your project.

```sh
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

You can add the SDK as a dependency using the composer.phar CLI:

```sh
php composer.phar require irazasyed/telegram-bot-sdk ^2.0
```

Or if you already have composer installed globally, then simply execute:

```sh
composer require irazasyed/telegram-bot-sdk ^2.0
```

Alternatively, you can specify the SDK as a dependency in your project's existing composer.json file:

```json
{
    "require": {
      "irazasyed/telegram-bot-sdk": "^2.0"
    }
}
```

After installing, you need to require Composer's autoloader if you want to use the library standalone:

```php
require 'vendor/autoload.php';
```

You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at [getcomposer.org][composer].

## Laravel Additional Steps

If you're using Laravel and would like to use the SDK with it, then follow the below instructions. Otherwise, you can skip this part.

#### Step 1: Add the Service Provider

Open `config/app.php` and, to your `providers` array at the bottom, add:

```php
Telegram\Bot\Laravel\TelegramServiceProvider::class
```

#### Step 2: Add Facade (Optional)

Optionally add an alias to make it easier to use the library. Open `config/app.php` and, to your "aliases" array at the bottom, add:

```php
'Telegram'  => Telegram\Bot\Laravel\Facades\Telegram::class
```

#### Step 3: Publish Configuration File

Open your terminal window and fire the following command to publish config file to your config directory:

```sh
php artisan vendor:publish --provider="Telegram\Bot\Laravel\TelegramServiceProvider"
```

OR

```sh
php artisan vendor:publish
```
The former command publishes config file for just this package and the latter publishes vendor config files for other packages too. Depending on what you want to do, you can use any (Doesn't really matter).

# Additional information

> The library takes advantage of the amazing Laravel Collection API to automatically map the data.
> So it's a lot easier to work with the array of data. Supports all the methods listed on the [official docs](http://laravel.com/docs/5.1/collections).

Any issues, feedback, suggestions or questions please use issue tracker [here](https://github.com/irazasyed/telegram-bot-sdk/issues).

# Contributing

Thank you for considering contributing to the project. Please review the [CONTRIBUTING](contributing.md) guidelines before submitting any pull requests.

Thanks to [All Contributors](https://github.com/irazasyed/telegram-bot-sdk/graphs/contributors).

# License

This project is released under the [BSD 3-Clause](license.md) License.

[telegram-bot]: https://core.telegram.org/bots
[composer]: http://getcomposer.org/


