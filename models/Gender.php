<?php
/**
 * @author Bryan Tan <bryantan16@gmail.com>
 */

namespace bryglen\kairos\models;

class Gender extends AbstractModel
{
    const TYPE_M = 'M';
    const TYPE_F = 'F';

    public $type;
    public $confidence;
} 