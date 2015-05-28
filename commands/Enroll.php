<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\commands;

use bryglen\kairos\models\Gender;
use bryglen\kairos\models\Image;
use bryglen\kairos\models\Transaction;

class Enroll extends BaseCommand
{
    public function post($image, $gallery_name, $subject_id, $options = array())
    {
        $options['image'] = $image;
        $options['subject_id'] = $subject_id;
        $options['gallery_name'] = $gallery_name;
        $response = $this->getClient()->post('enroll', null, $options)->send();
        return $this->populateResponse($response);
    }

    public function populateResponse($response)
    {
        if (!$response) {
            return null;
        }
        $responseArrays = json_decode($response, 1);
        $imagesResponse = isset($responseArrays['images']) ? $responseArrays['images'] : [];

        $images = [];
        foreach ($imagesResponse as $imageResponse) {
            $image = new Image();
            $image->setAttributes($imageResponse);

            $transaction = new Transaction();
            $transaction->attributes = isset($imageResponse['transaction']) ? $imageResponse['transaction'] : [];

            $gender = null;
            if (isset($imageResponse['attributes']['gender'])) {
                $gender = new Gender();
                $gender->attributes = $imageResponse['attributes']['gender'];
            }

            $image->imageAttributes['gender'] = $gender;
            $image->transaction = $transaction;

            $images = $image;
        }

        return $images;
    }
} 