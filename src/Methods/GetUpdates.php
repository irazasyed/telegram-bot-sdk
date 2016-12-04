<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Update;
use Telegram\Bot\Events\UpdateWasReceived;

/**
 * Class GetUpdates
 *
 * Use this method to receive incoming updates using long polling.
 *
 * <code>
 * $params = [
 *   'offset'          => '',
 *   'limit'           => '',
 *   'timeout'         => '',
 *   'allowed_updates' => [],
 * ];
 * </code>
 *
 * @see https://core.telegram.org/bots/api#getupdates Documentation for getUpdates.
 *
 * @method GetUpdates offset($offset = null) int|null
 * @method GetUpdates limit($limit = null) int|null
 * @method GetUpdates timeout($timeout = null) int|null
 * @method GetUpdates allowedUpdates($allowedUpdates = null) array|null
 *
 * @method Update[] getResult($dumpAndDie = false)
 */
class GetUpdates extends Method
{
    /** @var bool Should Emit Events */
    protected $shouldEmitEvents = true;

    /**
     * @param bool $shouldEmitEvents
     *
     * @return $this
     */
    public function shouldEmitEvents($shouldEmitEvents)
    {
        $this->shouldEmitEvents = $shouldEmitEvents;

        return $this;
    }

    /** {@inheritdoc} */
    protected function returns()
    {
        return collect($this->factory->response()->getResult())
            ->map(function ($data) {

                $update = new Update($data);

                if ($this->shouldEmitEvents) {
                    $this->factory->getTelegram()->emitEvent(
                        new UpdateWasReceived($update, $this->factory->getTelegram())
                    );
                }

                return $update;
            })
            ->all();
    }
}