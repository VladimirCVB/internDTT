<?php

use Phalcon\Mvc\Model;

class Listings extends Model
{

    public function beforeCreate()
    {
        // Set the creation date
        $this->post_date = date('Y-m-d');
    }

    public function beforeUpdate()
    {
        // Set the modification date
        $this->inactive_date = date('Y-m-d');
    }

    public $id;
    public $user_id;
    public $house_id;
    public $active;
}