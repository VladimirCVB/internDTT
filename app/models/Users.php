<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public $id;
    public $user_type;
    public $name;
    public $email;
    public $password;
}