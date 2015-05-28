<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos;

use bryglen\commands\Detect;
use bryglen\commands\Enroll;
use bryglen\commands\Recognize;
use Guzzle\Http\Client;

class Kairos
{
    public $hostname = 'https://api.kairos.com';
    public $appId;
    public $appLey;

    private $_client = null;

    public function __construct($appId, $appKey)
    {
        $this->appId = $appId;
        $this->appKey = $appKey;
    }

    public function getDetect()
    {
        return new Detect($this->getClient());
    }

    public function getEnroll()
    {
        return new Enroll($this->getClient());
    }

    public function getRecognize()
    {
        return new Recognize($this->getClient());
    }

    public function getClient()
    {
        if ($this->_client === null) {
            $this->_client = new Client($this->hostname, [
                'app_id' => $this->appId,
                'app_key' => $this->appKey
            ]);
        }

        return $this->_client;
    }
} 