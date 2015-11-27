<?php

namespace Telegram\Bot\Commands;

/**
 * Interface CommandInterface.
 */
interface CommandInterface
{
    /**
     * Process Inbound Command.
     *
     * @param $telegram
     * @param $arguments
     * @param $update
     *
     * @return mixed
     */
    public function make($telegram, $arguments, $update);

    /**
     * Process the command.
     *
     * @param $arguments
     *
     * @return mixed
     */
    public function handle($arguments);
}
