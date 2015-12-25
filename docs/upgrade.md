# Upgrade Guide

Please make sure you are viewing this file on the master branch. Check out the [CHANGELOG][changelog] for detailed info on whats changed.

## Upgrading To 2.0 from 1.x

There are some breaking and major changes in this new version. Follow the below instructions to apply the changes.

#### Upgrading Your Composer Dependency

To update the package in composer, fire the following command in your terminal:

```sh
$ composer require irazasyed/telegram-bot-sdk ^2.0
```

### Updating method parameters

Due to rapid amount of changes Telegram have made to their method parameter names and order, this version now requires all main methods to be called with an _array of parameters_ rather than _individual parameters_.

The affected methods are:

```php
 sendMessage()
 forwardMessage()
 sendPhoto()
 sendAudio()
 sendDocument()
 sendSticker()
 sendVideo()
 sendVoice()
 sendLocation()
 sendChatAction()
 getUserProfilePhotos()
 getUpdates()
 setWebhook()
 getFile()
 replyKeyboardMarkup()
 replyKeyboardHide()
 forceReply()
```

 For example, in version 1.0 of the api the `sendMessage()` method would have been called as follows:
 
```php
$response = $telegram->sendMessage('CHAT_ID', 'Hello World');
```

 You must now pass an associative array to the method instead like so:
 
```php
$response = $telegram->sendMessage([
	'chat_id' => 'CHAT_ID', 
	'text' => 'Hello World'
]);
```

All methods in the API are heavily documented, follow the official Telegram documentation and should provide easy guidance of required array key names, especially if you use an IDE.

## Upgrading To 1.0 from 0.x

There are some breaking and major changes in this new version. Follow the below instructions to apply the changes.

#### Upgrading Your Composer Dependency

To update the package in composer, fire the following command in your terminal:

```sh
$ composer require irazasyed/telegram-bot-sdk ^1.0
```

#### Updating Namespace

In this version, The package's namespace has been renamed from `Irazasyed\Telegram` to `Telegram\Bot`. So you need to update the namespace across your project wherever you're injecting any of the classes from the Package.

#### Initializing Library (For Standalone Usage Only)

Since the namespace has been changed, You need to update the way you initialise the library as well. Change `Irazasyed\Telegram\Telegram` to `Telegram\Bot\Api` and you can initialize like below:

```php
$telegram = new Telegram\Bot\Api($token);
```

#### Updating `sendAudio` Method

If you're using `sendAudio()` method anywhere in your project, Make sure you update that as per the new parameters and API change. Refer the [CHANGELOG][changelog] and API [file](https://github.com/irazasyed/telegram-bot-sdk/blob/v1.0.0/src/Api.php#L297-L324).

### Upgrading To 1.0 in Laravel / Lumen

Addition to the above instructions, You also need to apply the below instructions to get the package working in your Laravel or Lumen Project.

#### Update Service Provider

Update the `providers` array in `config/app.php` configuration file.

**FROM:** 

```php
Irazasyed\Telegram\Laravel\TelegramServiceProvider::class
```

**TO:**

```php
Telegram\Bot\Laravel\TelegramServiceProvider::class
```

#### Update Facade

If you use facade, then you need to update the `aliases` array in `config/app.php` configuration file.

**FROM:**

```php
'Telegram'  => Irazasyed\Telegram\Laravel\Facades\Telegram::class
```

**TO:**

```php
'Telegram'  => Telegram\Bot\Laravel\Facades\Telegram::class
```

#### Republish Configuration File

Fire the following command to apply the new changes. **Please note**, The below command will overwrite your current changes to the config file, So take a backup before firing this command:


```sh
$ php artisan vendor:publish --provider="Telegram\Bot\Laravel\TelegramServiceProvider" --force
```

That's all folks, Enjoy! 

Always make sure to update the package in your project to latest version to apply all the bug-fixes, security updates, tweaks and other cool new features.

[changelog]: changelog.md

