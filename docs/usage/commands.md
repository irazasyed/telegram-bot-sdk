# Commands

## Introduction

The SDK comes with a commands system that lets you handle and manage all inbound commands seamlessly and efficiently. The Commands Handler System is smart enough to trigger the right command when it sees one in an inbound message from Telegram. The commands are lazy loaded and processed on-demand, So registering them won't cause any performance issues to your application.

Lets get started with writing and registering our command.

## Writing Commands

First step before the Commands Handler System can start handling all your inbound commands is to write one. All the commands you write should extend the `Telegram\Bot\Commands\Command` class which is an implementation of [Telegram\Bot\Commands\CommandInterface](https://github.com/irazasyed/telegram-bot-sdk/blob/master/src/Commands/CommandInterface.php). You may store your custom commands in any directory as long as your commands can be autoloaded based on your `composer.json` settings and are registered properly with the Commands Handler System.

So for this example, Will build a `/start` command which will be triggered when a user sends `/start` or when they start an interaction with your bot for the first time.

### Command Structure

You should always add the `$name` and `$description` properties of the class with the appropriate values, which will be used when displaying a list of commands as well as when processing inbound message.

Example Command:

```php
<?php

namespace Vendor\App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => 'Hello! Welcome to our bot, Here are our available commands:']);

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will prepare a list of available commands and send the user.
        // First, Get an array of all registered commands
        // They'll be in 'command-name' => 'Command Handler Class' format.
        $commands = $this->getTelegram()->getCommands();

        // Build the list
        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        // Reply with the commands list
        $this->replyWithMessage(['text' => $response]);

        // Trigger another command dynamically from within this command
        // When you want to chain multiple commands within one or process the request further.
        // The method supports second parameter arguments which you can optionally pass, By default
        // it'll pass the same arguments that are received for this command originally.
        $this->triggerCommand('subscribe');
    }
}
```

Notice, The `$name` of the command is `start` so when a user sends `/start`, this class would be triggered.
So always make sure the name is correct and in lowercase. The description is helpful when you get a list of all the available commands either with the `/help` command or for other purposes using the `getCommands()` method.

All the commands you create should implement the `handle($arguments)` method which would be called when a user sends the command and will be passed with the arguments (Currently we don't break the arguments into an array but you can use methods like `explode()` to break by space and use it for whatever purposes).

In your handle method, You also get access to `getTelegram()` and `getUpdate()` methods which gives you access to the super class and the original update object sent from Telegram.

The commands system as you can see in above example command comes with a few helper methods (They're optional just to help you and make things easier):

1. `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` - Basically, All the `send<API Method>` are supported and are pre-filled with the chat id of the message that triggered the command. All other params of each method can easily be passed to it like you would normally as per the docs (Exclude `chat_id` from the array since it's already being added.)
2. `triggerCommand(<Command Name>)` - This is useful to chain a bunch of commands within a command. Say for example, I want to fire the `/subscribe` command that is registered already with the Commands Handler System. By using this method, I can tell the system to simulate the `/subscribe` command as if the user sent it and i can then process such request normally within that command. I would use this method to trigger that command in my `/start` command for example. So as soon as the user sends `/start` or interacts with my bot for the first time, they would also be automatically triggering `/subscribe` command which for example could be subscribing them for some alerts from your bot. The function supports second param called `$arguments` which is optional and can be used to send some arguments from the original command (The one which is triggering) to the other command. By default, The arguments would be the same as what Telegram originally sent it.

If a command is not registered but the user fires one (Lets say an invalid command), By default the system will look for a help command if its registered and if yes, then it'll be triggered. So the default help command class if you were to use would respond the user with the available list of commands with description.

## Registering Commands

The first step is to register our commands after we create one.

### Registering Single Command

In order to register a single command, we can make use of `addCommand()` method which supports either the command object or full path to the command itself and it'll automatically initialize it behind the scenes.

**Standalone:**

```php
$telegram->addCommand(Telegram\Bot\Commands\HelpCommand::class);

// OR

$command = new Telegram\Bot\Commands\HelpCommand();
$telegram->addCommand($command);
```

**Laravel:**
Registering Commands in Laravel is actually very easy. Simply open the `telegram.php` configuration file and add all your commands full path to the `commands` array and the SDK will take care of the rest.

Example:

```php
'commands' => [
    Telegram\Bot\Commands\HelpCommand::class,
    Vendor\Project\Commands\StartCommand::class,
    Vendor\Project\Commands\SettingsCommand::class,
]
```

By default, The SDK registers a Help Command in Laravel, But you can either choose to disable it by simply commenting out the HelpCommand line/removing it completely or Replace it with your own Help Command.

You can also register/un-register commands on-fly using the same `addCommand()` or `removeCommand()` methods like above in Standalone example.

Example:

```php
Telegram::addCommand(Telegram\Bot\Commands\HelpCommand::class);

// OR

$command = new Telegram\Bot\Commands\HelpCommand();
Telegram::addCommand($command);
```

### Registering Multiple Commands

To register multiple commands, You can pass an array with all the commands that has to be registered to the `addCommands()` method.

Example:
```php
// Standalone
$telegram->addCommands([
   Telegram\Bot\Commands\HelpCommand::class,
   Vendor\Project\TestCommand::class,
   Vendor\Project\StartCommand::class,
]);

// Laravel
Telegram::addCommands([
   Telegram\Bot\Commands\HelpCommand::class,
   Vendor\Project\TestCommand::class,
   Vendor\Project\StartCommand::class,
]);
```

> **Note:** All commands are lazy loaded.

There is also a `removeCommands()` method to un-register multiple commands.

## Handling Commands

Now to handle inbound commands, You have to use the new method called `commandsHandler()`.
Here's an example used with a Webhook registered:

```php
// Laravel
Route::post('/<token>/webhook', function () {
    $update = Telegram::commandsHandler(true);
	
	// Commands handler method returns an Update object.
	// So you can further process $update object 
	// to however you want.
	
    return 'ok';
});

// Standalone
$update = $telegram->commandsHandler(true);
```

The method accepts a boolean value, Defaults to `false` which means the commands should manually be processed using `getUpdates()` method. Set it to `true` to process incoming updates sent from Telegram to your Webhook. The commands handler system will go through the incoming Update object to see if there is any command that matches the registered once and process them accordingly.

Commands Handler method will always return an Update object (Whether it processes the command or not), So you can use it to process further or for anything. 

**Example**: In case the incoming message is not a command, You can use the returned Update object to save the incoming message and or respond accordingly.