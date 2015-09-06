Upgrade Guide
=============

Please make sure you are viewing this file on the master branch. Check out the [CHANGELOG](https://github.com/irazasyed/telegram-bot-sdk/blob/master/CHANGELOG.md) for detailed info on whats changed.

# Updating from 0.2.x to 1.0.x

There are some breaking and major changes in this new version. Follow the below instructions.

1. Update the package by firing the following command in your terminal:

```
$ composer require irazasyed/telegram-bot-sdk ^1.0
```

2. The Namespace has been renamed from `Irazasyed\Telegram` to `Telegram\Bot`, So you need to update the namespace across your project wherever you're injecting any of the classes from the Package.

3. The `Telegram.php` file has been renamed to `Api.php`, Hence you need to change `Irazasyed\Telegram\Telegram` to `Telegram\Bot\Api` if you're injecting in your project or initilizating the library. Ex:

```php
$telegram = new Telegram\Bot\Api($token);
```

4. If you're using `sendAudio()` method anywhere in your project, Make sure you update that as per the new parameters and API change. Refer changelog and [this](https://github.com/irazasyed/telegram-bot-sdk/blob/master/src/Api.php#L297-L324).

## Upgrading in Laravel / Lumen Project
If you're on Laravel or Lumen, The follow the below instructions to apply the upgrade.

1. Update service provider in `config/app.php` "providers" array.

**FROM:** 

```php
Irazasyed\Telegram\Laravel\TelegramServiceProvider::class
```

**TO:**

```php
Telegram\Bot\Laravel\TelegramServiceProvider::class
```

2. Update Facade in `config/app.php` "aliases" array.

**FROM:**

```php
'Telegram'  => Irazasyed\Telegram\Laravel\Facades\Telegram::class
```

**TO:**

```php
'Telegram'  => Telegram\Bot\Laravel\Facades\Telegram::class
```

3. Republish the config file by firing the following command. If you've made any changes to the config file, they'll be overwritten, Take a backup before firing this command:

```php
$ php artisan vendor:publish --provider="Telegram\Bot\Laravel\TelegramServiceProvider" --force
```

That's all, Enjoy! And always make sure to update the package in your project to latest version to apply all the bugfixes, security updates, tweaks and other cool new features.

