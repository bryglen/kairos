<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\models;

class Image extends AbstractModel
{
    public $time;
    public $status;
    public $file;
    public $width;
    public $height;

    public $face = [];
    public $transaction;
    public $attributes = [];
}