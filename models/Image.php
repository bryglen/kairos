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

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function isSuccess()
    {
        return in_array(strtolower($this->status), ['success', 'complete']) || in_array(strtolower($this->transaction->status), ['success', 'complete']);
    }
}