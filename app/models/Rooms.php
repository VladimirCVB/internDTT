<?php

use Phalcon\Mvc\Model;

class Rooms extends Model
{
    public $id;
    public $house_id;
    public $room_type;
    public $width;
    public $length;
    public $height;
}