<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\commands;

use bryglen\kairos\models\GalleryName;

class Gallery extends BaseCommand
{
    public function listAll()
    {
        $this->rawResponse = $this->getClient()->post('gallery/list_all')->send();
        return $this->populateResponse($this->rawResponse->getBody());
    }

    public function populateResponse($response)
    {
        if (!$response) {
            return null;
        }
        $responseArrays = json_decode($response, 1);

        $gallery = new \bryglen\kairos\models\Gallery();
        $gallery->setAttributes($responseArrays);
    }
} 