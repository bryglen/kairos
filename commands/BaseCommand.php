<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\commands;

use bryglen\kairos\KairosException;
use Guzzle\Http\Client;

class BaseCommand
{
    public $rawResponse;
    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    public function setClient($client)
    {
        $this->_client = $client;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param $response
     * @throws \bryglen\kairos\KairosException
     */
    public function checkError($response)
    {
        if (isset($response['Errors'])) {
            foreach ($response['Errors'] as $error) {
                if (isset($error['Message']) && isset($error['ErrCode'])) {
                    throw new KairosException($error['Message'], $error['ErrCode']);
                } else {
                    throw new KairosException("Unknown Error");
                }
            }
        }
    }
} 