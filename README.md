Telegram Bot API PHP SDK
=========================

[![Latest Version](https://img.shields.io/github/release/irazasyed/telegram-bot-sdk.svg?style=flat-square)](https://github.com/irazasyed/telegram-bot-sdk/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/irazasyed/telegram-bot-sdk.svg?style=flat-square)](https://packagist.org/packages/irazasyed/telegram-bot-sdk)

> The (Unofficial) Telegram Bot API PHP SDK. Lets you develop Telegram Bots easily! Supports Laravel out of the box.

## Quick start


### Required setup / Installation

#### Install Through Composer

You can either add the package directly by firing this command

```cli
$ composer require irazasyed/telegram-bot-sdk
```

### Laravel Installation

If you're using Laravel, then follow the below instructions. Otherwise, you can skip this part.

#### Step 1: Add the Service Provider

Open `config/app.php` and, to your "providers" array at the bottom, add:

```php
'Irazasyed\Telegram\Laravel\TelegramServiceProvider'
```

#### Step 2: Add Facade (Optional)

Optionally add an alias to make it easier to use the library. Open `config/app.php` and, to your "aliases" array at the bottom, add:

```php
'Telegram'  => 'Irazasyed\Telegram\Laravel\Facades\Telegram'
```

#### Step 3: Publish Config

Open your terminal window and fire the following command to publish config file to your config directory:

```cli
$ php artisan vendor:publish --provider="Irazasyed\Telegram\Laravel\TelegramServiceProvider"
```

OR

```cli
$ php artisan vendor:publish
```

The former command publishes config file for just this package and the latter publishes vendor config files for other packages too. Depending on what you want to do, you can use any (Doesn't really matter).


## Laravel Usage

Open `telegram.php` file in `config` directory and set the `bot_token` with your Telegram's Bot Access Token or you could also set environment variable `TELEGRAM_BOT_TOKEN`.
Refer the config file for other default configuration settings.

All the methods listed on [Telegam Bot API](https://core.telegram.org/bots/api) page are fully supported.

### Example Usage

Send a message

```php
$telegram = Telegram::sendMessage('CHAT_ID', 'Hello World');
$messageId = $telegram->getMessageId();
```

### Laravel Config Overview

Open the config file for detailed comments for each option.

Set your Telegram Bot Access Token in `bot_token` key **[REQUIRED]**

```php
'bot_token'      => '1234:ABCD',
```

All other configs are optional, use as per your requirements.

To Make Async Requests, set `async_requests` to true.

```php
'async_requests'  => true,
```

## Standalone Usage

Assuming you're using composer's autoloader.

### Initialize Library

```php
use Irazasyed\Telegram\Telegram;

$telegram = new Telegram('BOT TOKEN');
```

### Test Bot

A simple method for testing your bot's auth token.
Returns basic information about the bot in form of a User object.
See [getMe](https://core.telegram.org/bots/api#getme) docs for more details.

```php
$response = $telegram->getMe();

$botId = $response->getId();
$firstName = $response->getFirstName();
$lastName = $response->getLastName();
$username = $response->getUsername();
```

### Send a Message

See [sendMessage](https://core.telegram.org/bots/api#sendmessage) docs for a list of supported parameters and other info.

```php
$response = $telegram->sendMessage('CHAT_ID', 'Hello World');
$messageId = $response->getMessageId();
```

### Send a Photo

See [sendPhoto](https://core.telegram.org/bots/api#sendphoto) docs for a list of supported parameters and other info.

```php
$response = $telegram->sendPhoto('CHAT_ID', 'path/to/photo.jpg', 'Some caption');
$messageId = $response->getMessageId();
```

### Forward a Message

See [forwardMessage](https://core.telegram.org/bots/api#forwardmessage) docs for a list of supported parameters and other info.

```php
$response = $telegram->forwardMessage('CHAT_ID', 'FROM_CHAT_ID', 'MESSAGE_ID');
$messageId = $response->getMessageId();
```

### Send a Chat Action

See [sendChatAction](https://core.telegram.org/bots/api#sendchataction) docs for a list of supported actions and other info.

```php
$telegram->sendChatAction('CHAT_ID', 'upload_photo');
```

### Get User Profile Photos

See [getUserProfilePhotos](https://core.telegram.org/bots/api#getuserprofilephotos) docs for a list of supported parameters and other info.

```php
$response = $telegram->getUserProfilePhotos('USER_ID');
$photos_count = $response->getTotalCount();
$photos = $response->getPhotos();
```

### Get Updates

See [getUpdates](https://core.telegram.org/bots/api#getupdates) docs for a list of supported parameters and other info.

```php
$updates = $telegram->getUpdates();
```

The library supports all the methods listed on Bot API docs [page](https://core.telegram.org/bots/api#available-methods). More examples coming soon.

### Webhook

#### Set Webhook

See [setWebhook](https://core.telegram.org/bots/api#setwebhook) docs for a list of supported parameters and other info.

```php
$response = $telegram->setWebhook('https://example.com/api/updates');
```

#### Remove Webhook

To remove webhook (if it was set before).

```php
$response = $telegram->removeWebhook();
```

## Asynchronous Requests (Non-Blocking)

By default, sending an API request to Telegram Bot API will be a synchronous request, and block the execution of the script until it gets a response from the server or timeouts after 60 secs (throwing a Guzzle exception).
However, an asynchronous non-blocking request can be sent by calling `setAsyncRequest(true)` before making any API request or at the time of initializing the library:

### Make specific API requests async
```php
// When building the API request, just make a call to the setAsyncRequest method passing true
// now making a request won't block the execution of the script.
// Similarly if you want to do the other way around, just pass false (Make a specific API call a synchronous request).
$telegram
   ->setAsyncRequest(true)
   ->sendPhoto('CHAT_ID', 'path/to/photo.jpg');
```

### Make all API requests async

You can make all API requests async (non-blocking) when initializing library.

Just pass the second parameter a boolean value `true`. Defaults to `false`.

```php
use Irazasyed\Telegram\Telegram;

$telegram = new Telegram('BOT TOKEN', true);
```

If you want all the requests to be asynchronous non-blocking requests and only a specific call to be synchronous request,
you can pass the `setAsyncRequest(false)` before making an API call, see above for example.

This means that we are sending the request and not waiting for a response.
The TelegramResponse object that you will get back has NULL for HTTP status code.


## Additional information

> The library takes advantage of the amazing Laravel Collection API to automatically map the data.
> So it's a lot easier to work with the array of data. Supports all the methods listed on the [official docs](http://laravel.com/docs/5.1/collections).

Any issues, feedback, suggestions or questions please use issue tracker [here](https://github.com/irazasyed/telegram-bot-sdk/issues).

## License

[GPL-3](LICENSE) © [Syed I.R](http://lk.gd/irazasyed)
