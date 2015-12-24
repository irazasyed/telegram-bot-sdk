# Available Methods & Examples

The library supports all the methods listed on Telegram Bot API docs [page](https://core.telegram.org/bots/api#available-methods).

## Send a Message

See [sendMessage](https://core.telegram.org/bots/api#sendmessage) docs for a list of supported parameters and other info.

```php
$response = $telegram->sendMessage([
	'chat_id' => 'CHAT_ID', 
	'text' => 'Hello World'
]);

$messageId = $response->getMessageId();
```

## Forward a Message

See [forwardMessage](https://core.telegram.org/bots/api#forwardmessage) docs for a list of supported parameters and other info.

```php
$response = $telegram->forwardMessage([
	'chat_id' => 'CHAT_ID', 
	'from_chat_id' => 'FROM_CHAT_ID', 
	'message_id' => 'MESSAGE_ID'
]);

$messageId = $response->getMessageId();
```

## Send a Photo

See [sendPhoto](https://core.telegram.org/bots/api#sendphoto) docs for a list of supported parameters and other info.

```php
$response = $telegram->sendPhoto([
	'chat_id' => 'CHAT_ID', 
	'photo' => 'path/to/photo.jpg', 
	'caption' => 'Some caption'
]);

$messageId = $response->getMessageId();
```

The ability to send an image directly from an URL has now been added to the library. Instead of supplying a local path and filename, you may now pass the image URL.

```php
$response = $telegram->sendPhoto([
	'chat_id' => 'CHAT_ID', 
	'photo' => 'http://example.com/photos/image.jpg',
	'caption' => 'Some caption'
]);

$messageId = $response->getMessageId();
```

## Send a Chat Action

See [sendChatAction](https://core.telegram.org/bots/api#sendchataction) docs for a list of supported actions and other info.

```php
$telegram->sendChatAction([
	'chat_id' => 'CHAT_ID', 
	'action' => 'upload_photo'
]);
```

There is also a new helper method for supplying the chat action. This is especially useful with code completion with your IDE.

```php
$telegram->sendChatAction([
	'chat_id' => 'CHAT_ID', 
	'action' => Actions::RECORD_VIDEO
]);
```

## Get User Profile Photos

See [getUserProfilePhotos](https://core.telegram.org/bots/api#getuserprofilephotos) docs for a list of supported parameters and other info.

```php
$response = $telegram->getUserProfilePhotos(['user_id' => 'USER_ID']);

$photos_count = $response->getTotalCount();
$photos = $response->getPhotos();
```

## Get Updates

See [getUpdates](https://core.telegram.org/bots/api#getupdates) docs for a list of supported parameters and other info.

```php
$updates = $telegram->getUpdates();
```