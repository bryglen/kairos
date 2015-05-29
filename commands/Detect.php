<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\commands;

use bryglen\kairos\models\Face;
use bryglen\kairos\models\Gender;
use bryglen\kairos\models\Image;

class Detect extends BaseCommand
{
    /**
     * @param $image
     * @param array $options
     * @return Image[]
     */
    public function post($image, $options = [])
    {
        $body = $options;
        $body['image'] = $image;
        $this->rawResponse = $this->getClient()->post('detect', null, json_encode($body))->send();
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

            $faces = [];
            foreach ($imageArray['faces'] as $faceArray) {
                $face = new Face();
                $face->setAttributes($faceArray);

                if (isset($faceArray['attributes']['gender'])) {
                    $gender = new Gender();
                    $gender->setAttributes($faceArray['attributes']['gender']);

                    $face->attributes['gender'] = $gender;
                }

                $faces[] = $face;
            }
            $image->faces = $faces;

            $images[] = $image;
        }

        return $images;
    }
} 