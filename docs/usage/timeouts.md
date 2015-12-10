# Request timeouts

By default, there is a 60 second timeout for waiting response from Telegram Bot API servers, after this time passed Guzzle exception will be thrown.
However, it is possible to change this behaviour by calling `setTimeOut(SECONDS)` or `setConnectTimeOut(SECONDS)` before making any API request or at the time of initializing the library.

## Connection timeout
Default connection timeout is 10 seconds. It can be changed it by calling `setConnectTimeOut(SECONDS)`.

```php
// Standalone
$telegram
   ->setConnectTimeOut(1)
   ->sendPhoto(['chat_id' => 'CHAT_ID', 'photo' => 'path/to/photo.jpg']);

// Laravel
Telegram::setConnectTimeOut(1);
Telegram::sendPhoto(['chat_id' => 'CHAT_ID', 'photo' => 'path/to/photo.jpg']);
```

## General timeout
Default timeout of Telegram API server response is 60 seconds. It can be changed by calling `setTimeOut(SECONDS)`.

```php
// Standalone
$telegram->setTimeOut(30);
$updates = $telegram->getUpdates(['timeout' => 30]);
$telegram->setTimeOut(5);
$telegram->sendMessage(['chat_id' => 'CHAT_ID', 'text' => 'message']);

// Laravel
Telegram::setTimeOut(30);
$updates = Telegram::getUpdates(['timeout' => 30]);
Telegram::setTimeOut(5);
Telegram::sendMessage(['chat_id' => 'CHAT_ID', 'text' => 'message']);
```
