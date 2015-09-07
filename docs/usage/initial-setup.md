# Initial Setup

All the methods listed on [Telegram Bot API](https://core.telegram.org/bots/api) page are fully supported by this SDK.

## Standalone Setup

In order to use the library in your project, You need to install the SDK with Composer. Refer the [installation](../index.md#installation) page for more details on how to install with Composer and autoload in your project.

### Initialize Library

First step is to initialize the library. Once you do that, You'll get access to all the available API Methods to make requests to Telegram.

```php
use Telegram\Bot\Api;

$telegram = new Api('BOT TOKEN');
```

## Laravel Setup

Open `telegram.php` configuration file in `config` directory and set the `bot_token` with your Telegram's Bot Access Token or you could also set environment variable `TELEGRAM_BOT_TOKEN` with the appropriate value.
Refer the configuration file for other default configuration settings.

### Config Overview

Open the config file for detailed comments for each option.

Set your Telegram Bot Access Token in `bot_token` key **[REQUIRED]**

```php
'bot_token' => '1234:ABCD'
```

All other configs are optional, use as per your requirements.

## Test Bot

A simple method for testing your bot's auth token.
Returns basic information about the bot in form of a User object.

See [getMe](https://core.telegram.org/bots/api#getme) docs for more details.

```php
// Standalone
$response = $telegram->getMe();

// Laravel
$response = Telegram::getMe();

$botId = $response->getId();
$firstName = $response->getFirstName();
$username = $response->getUsername();
```
