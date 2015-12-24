# Keyboards

> One of the coolest things about Telegram Bot API are the new custom keyboards. Whenever your bot sends a message, it can pass along a special keyboard with predefined reply options. Telegram apps that receive the message will display your keyboard to the user. Tapping any of the buttons will immediately send the respective command. This way you can drastically simplify user interaction with your bot.

> Telegram currently support text and emoji for your buttons. Here are some custom keyboard examples:

<p align="center">
<img src="https://core.telegram.org/file/811140184/1/5YJxx-rostA/ad3f74094485fb97bd" title="Keyboard for a poll bot" style="max-height: 300px; padding: 10px 5px">
<img src="https://core.telegram.org/file/811140880/1/jS-YSVkDCNQ/b397dfcefc6da0dc70" title="Keyboard for a calculator bot. Because you can." style="max-height: 300px; padding: 10px 5px">
<img src="https://core.telegram.org/file/811140733/2/KoysqJKQ_kI/a1ee46a377796c3961" title="Keyboard for a trivia bot" style="max-height: 300px; padding: 10px 5px">
</p>

## Reply Keyboard Markup

The below example will send a message and automatically show a custom keyboard.
If `one_time_keyboard` is set as true, the keyboard will be shown only once.

See [ReplyKeyboardMarkup](https://core.telegram.org/bots/api#replykeyboardmarkup) docs for a list of supported parameters and other info.

Example:

```php
$keyboard = [
    ['7', '8', '9'],
    ['4', '5', '6'],
    ['1', '2', '3'],
         ['0']
];

$reply_markup = $telegram->replyKeyboardMarkup([
	'keyboard' => $keyboard, 
	'resize_keyboard' => true, 
	'one_time_keyboard' => true
]);

$response = $telegram->sendMessage([
	'chat_id' => 'CHAT_ID', 
	'text' => 'Hello World', 
	'reply_markup' => $reply_markup
]);

$messageId = $response->getMessageId();
```

## Reply Keyboard Hide

Telegram clients will hide the current custom keyboard and display the default letter-keyboard.
See [ReplyKeyboardHide](https://core.telegram.org/bots/api#replykeyboardhide) docs for more info.

If called with no parameters, the `selective` option defaults to `false`.
```php
$reply_markup = $telegram->replyKeyboardHide();

$response = $telegram->sendMessage([
	'chat_id' => 'CHAT_ID', 
	'text' => 'Hello World', 
	'reply_markup' => $reply_markup
]);
```

## Force Reply

Shows reply interface to the user, as if they manually selected the bot‘s message and tapped ’Reply'.
See [ForceReply](https://core.telegram.org/bots/api#forcereply) docs for more info.

If called with no parameters, the `selective` option defaults to `false`.

```php
$reply_markup = $telegram->forceReply();

$response = $telegram->sendMessage([
	'chat_id' => 'CHAT_ID', 
	'text' => 'Hello World', 
	'reply_markup' => $reply_markup
]);
```