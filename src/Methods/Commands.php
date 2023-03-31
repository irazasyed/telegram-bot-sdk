<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\BotCommand;
use Telegram\Bot\Traits\Http;

/**
 * Class Commands.
 *
 * @mixin Http
 */
trait Commands
{
    /**
     * Change the list of the bots commands.
     *
     * <code>
     * $params = [
     *      'commands'      => '',  // array           - Required. A JSON-serialized list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     *      'scope'         => '',  // BotCommandScope - (Optional). A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to BotCommandScopeDefault.
     *      'language_code' => '',  // String          - (Optional). A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setmycommands
     *
     * @param  array  $params Where "commands" key is required, where value is a serialized array of commands.
     *
     * @throws TelegramSDKException
     */
    public function setMyCommands(array $params): bool
    {
        $params['commands'] = is_string($params['commands'])
            ? $params['commands']
            : json_encode($params['commands'], JSON_THROW_ON_ERROR);

        return $this->post('setMyCommands', $params)->getResult();
    }

    /**
     * Delete the list of the bot's commands for the given scope and user language
     *
     * <code>
     * $params = [
     *      'scope'         => '',  // BotCommandScope - (Optional). A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to BotCommandScopeDefault.
     *      'language_code' => '',  // String          - (Optional). A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#deletemycommands
     *
     * @param  mixed[]  $params
     */
    public function deleteMyCommands(array $params = []): bool
    {
        return $this->post('deleteMyCommands', $params)->getResult();
    }

    /**
     * Get the current list of the bot's commands.
     *
     * <code>
     * $params = [
     *      'scope'         => '',  // BotCommandScope - (Optional). A JSON-serialized object, describing scope of users. Defaults to BotCommandScopeDefault.
     *      'language_code' => '',  // String          - (Optional). A two-letter ISO 639-1 language code or an empty string
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getmycommands
     *
     * @return BotCommand[]
     *
     * @throws TelegramSDKException
     */
    public function getMyCommands(array $params = []): array
    {
        return collect($this->get('getMyCommands', $params)->getResult())
            ->mapInto(BotCommand::class)
            ->all();
    }
}
