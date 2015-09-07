# Available Methods & Examples

The library supports all the methods listed on Telegram Bot API docs [page](https://core.telegram.org/bots/api#available-methods).

## Send a Message

See [sendMessage](https://core.telegram.org/bots/api#sendmessage) docs for a list of supported parameters and other info.

```php
$response = $telegram->sendMessage('CHAT_ID', 'Hello World');
$messageId = $response->getMessageId();
```

## Send a Photo

See [sendPhoto](https://core.telegram.org/bots/api#sendphoto) docs for a list of supported parameters and other info.

```php
$response = $telegram->sendPhoto('CHAT_ID', 'path/to/photo.jpg', 'Some caption');
$messageId = $response->getMessageId();
```

## Forward a Message

See [forwardMessage](https://core.telegram.org/bots/api#forwardmessage) docs for a list of supported parameters and other info.

```php
$response = $telegram->forwardMessage('CHAT_ID', 'FROM_CHAT_ID', 'MESSAGE_ID');
$messageId = $response->getMessageId();
```

## Send a Chat Action

See [sendChatAction](https://core.telegram.org/bots/api#sendchataction) docs for a list of supported actions and other info.

```php
$telegram->sendChatAction('CHAT_ID', 'upload_photo');
```

## Get User Profile Photos

See [getUserProfilePhotos](https://core.telegram.org/bots/api#getuserprofilephotos) docs for a list of supported parameters and other info.

```php
$response = $telegram->getUserProfilePhotos('USER_ID');
$photos_count = $response->getTotalCount();
$photos = $response->getPhotos();
```

## Get Updates

See [getUpdates](https://core.telegram.org/bots/api#getupdates) docs for a list of supported parameters and other info.

```php
$updates = $telegram->getUpdates();
```
