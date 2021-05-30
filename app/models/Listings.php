<?php

use Phalcon\Mvc\Model;

class Listings extends Model
{

    //Adding the creation date automatically
    public function beforeCreate()
    {
        // Set the creation date
        $this->post_date = date('Y-m-d');
    }

    //When modifying the listing (to active=false) the inactive_date is set to the present date. This is because we don't want to delete the listing right away. We will be removing the related data (such as the house or the rooms) and the listing will not be visible to the users anymore. It can still be deleted afterwards.
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