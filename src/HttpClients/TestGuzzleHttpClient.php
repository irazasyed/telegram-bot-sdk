<?php

namespace Telegram\Bot\HttpClients;

class TestGuzzleHttpClient extends GuzzleHttpClient
{
    /** @var  int */
    protected $timeOut;
    /** @var  int */
    protected $connectTimeOut;

    public function send(
        $url,
        $method,
        array $headers = [],
        array $options = [],
        $timeOut = 30,
        $isAsyncRequest = false,
        $connectTimeOut = 10
    ) {
        $this->timeOut = $timeOut;
        $this->connectTimeOut = $connectTimeOut;

        return parent::send(
            $url,
            $method,
            $headers,
            $options,
            $timeOut,
            $isAsyncRequest,
            $connectTimeOut
        );
    }

    /**
     * @return int|null
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @return int|null
     */
    public function getConnectTimeOut()
    {
        return $this->connectTimeOut;
    }

}