<?php

namespace Telegram\Bot\Methods;

trait Passport
{
    /**
     * Set Passport Data Errors.
     *
     * <code>
     * $params = [
     *   'user_id'                 => '',
     *   'errors'                  => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setpassportdataerrors
     *
     * @param array $params
     *
     * @return bool
     */
    public function setPassportDataErrors(array $params)
    {
        return $this->post('setPassportDataErrors', $params)->getResult();
    }
}
