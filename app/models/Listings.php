<?php

use Phalcon\Mvc\Model;

class Listings extends Model
{
    public $id;
    public $user_id;
    public $house_id;
    public $post_date;
    public $active;
    public $inactive_date;
}