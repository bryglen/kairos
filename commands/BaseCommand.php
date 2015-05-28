<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\commands;

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
} 