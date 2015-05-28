<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\commands;

use bryglen\kairos\models\Gender;
use bryglen\kairos\models\Image;
use bryglen\kairos\models\Transaction;

class Enroll extends BaseCommand
{
    public function post($image, $gallery_name, $subject_id, $options = [])
    {
        $body = $options;
        $body['image'] = $image;
        $body['subject_id'] = $subject_id;
        $body['gallery_name'] = $gallery_name;

        $this->rawResponse = $this->getClient()->post('enroll', null, json_encode($body))->send();
        return $this->populateResponse($this->rawResponse->getBody());
    }

    public function populateResponse($response)
    {
        if (!$response) {
            return null;
        }
        $responseArrays = json_decode($response, 1);
        $imageArrays = isset($responseArrays['images']) ? $responseArrays['images'] : [];

        $images = [];
        foreach ($imageArrays as $imageArray) {
            $image = new Image();
            $image->setAttributes($imageArray);

            $transaction = new Transaction();
            $transaction->setAttributes(isset($imageArray['transaction']) ? $imageArray['transaction'] : []);

            $gender = null;
            if (isset($imageArray['attributes']['gender'])) {
                $gender = new Gender();
                $gender->setAttributes($imageArray['attributes']['gender']);
            }

            $image->attributes['gender'] = $gender;
            $image->transaction = $transaction;

            $images[] = $image;
        }

        return $images;
    }
} 