<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\commands;

use bryglen\kairos\models\Candidate;
use bryglen\kairos\models\Image;
use bryglen\kairos\models\Transaction;

class Recognize extends BaseCommand
{
    /**
     * @param $image
     * @param $gallery_name
     * @param array $options
     * @return \bryglen\kairos\models\Image[]
     */
    public function post($image, $gallery_name, $options = [])
    {
        $body = $options;
        $body['image'] = $image;
        $body['gallery_name'] = $gallery_name;
        $this->rawResponse = $this->getClient()->post('recognize', null, json_encode($body))->send();
        return $this->populateResponse($this->rawResponse->getBody());
    }

    /**
     * @param $response
     * @return Image[]
     */
    public function populateResponse($response)
    {
        if (!$response) {
            return null;
        }

        $responseArrays = json_decode($response, 1);
        $this->checkError($responseArrays);
        $imageArrays = isset($responseArrays['images']) ? $responseArrays['images'] : [];

        $images = [];
        foreach ($imageArrays as $imageArray) {
            $image = new Image();
            $image->setAttributes($imageArray);

            $transaction = new Transaction();
            $transaction->setAttributes(isset($imageArray['transaction']) ? $imageArray['transaction'] : []);

            if (isset($imageArray['candidates'])) {
                foreach ($imageArray['candidates'] as $candidateArray) {
                    $candidate = new Candidate();
                    $candidate->setAttributes($candidateArray);
                    $image->candidates[] = $candidate;
                }
            }

            $images[] = $image;
        }

        return $images;
    }
} 