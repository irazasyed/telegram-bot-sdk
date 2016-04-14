<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputContactMessageContent
 *
 * <code>
 * $params = [
 *   'phone_number'     => '',
 *   'first_name'       => '',
 *   'last_name'        => '',
 * ];
 * </code>
 *
 * @method $this setPhoneNumber($string) Contact's phone number
 * @method $this setFirstName($string)   Contact's first name
 * @method $this setLastName($string)    Optional. Contact's last name
 */
class InputContactMessageContent extends InlineBaseObject
{

}
