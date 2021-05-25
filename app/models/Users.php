<?php

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class Users extends Model
{
    
    public $id;
    public $user_type;
    public $name;
    public $email;
    public $password;

    public function validation()
    {
        $validator = new Validation();
        
        $validator->add(
            "user_type",
            new InclusionIn(
                [
                    'user_type' => 'Type must be "admin" or "user"',
                    'domain' => [
                        'admin',
                        'user',
                    ],
                ]
            )
        );

        $validator->add(
            'email',
            new Uniqueness(
                [
                    'field'   => 'email',
                    'message' => 'The email address must be unique',
                ]
            )
        );

        $validator->add(
            'email',
            new Email(
                [
                    'field'   => 'email',
                    'message' => 'The email address must be valid',
                ]
            )
        );

        $validator->add(
            'name',
            new PresenceOf(
                [
                    'field'   => 'name',
                    'message' => 'You must enter a name',
                ]
            )
        );

        $validator->add(
            'password',
            new PresenceOf(
                [
                    'field'   => 'password',
                    'message' => 'You must enter a password',
                ]
            )
        );
        
        // Validate the validator
        return $this->validate($validator);
    }
}