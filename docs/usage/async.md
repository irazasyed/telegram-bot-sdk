# Asynchronous Requests (Non-Blocking)

By default, sending an API request to Telegram Bot API will be a synchronous request, and block the execution of the script until it gets a response from the server or timeouts after 60 secs (throwing a Guzzle exception).
However, an asynchronous non-blocking request can be sent by calling `setAsyncRequest(true)` before making any API request or at the time of initializing the library:

## Make Specific API Requests Async

```php
// When building the API request, just make a call to the setAsyncRequest method passing true
// now making a request won't block the execution of the script.
// Similarly if you want to do the other way around, just pass false (Make a specific API call a synchronous request).

// Standalone
$telegram
   ->setAsyncRequest(true)
   ->sendPhoto(['chat_id' => 'CHAT_ID', 'photo' => 'path/to/photo.jpg']);

// Laravel
Telegram::setAsyncRequest(true)
          ->sendPhoto(['chat_id' => 'CHAT_ID', 'photo' => 'path/to/photo.jpg']);
```

## Make All API Requests Async

You can make all API requests async (non-blocking), just apply the changes as per the below instructions.

### Standalone

Just pass the second parameter a boolean value `true`. Defaults to `false`.

```php
use Telegram\Bot\Api;

$telegram = new Api('BOT TOKEN', true);
```

### Laravel

To make all API requests async in Laravel, Simply set the `async_requests` option to `true` in `telegram.php` configuration file. You can also set the value in env variable `TELEGRAM_ASYNC_REQUESTS`.

If you want all the requests to be asynchronous non-blocking requests and only a specific call to be synchronous request, you can pass the `setAsyncRequest(false)` before making an API call, see above for example.

This means that we are sending the request and not waiting for a response.
The `TelegramResponse` object that you will get back has NULL for HTTP status code.
