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

    //Adding validator for specific fields
    public function validation()
    {
        $validator = new Validation();
        
        //Validating if the user type is of 'admin' or 'user'
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

        //Validating that there is no other user with the same email
        $validator->add(
            'email',
            new Uniqueness(
                [
                    'field'   => 'email',
                    'message' => 'The email address must be unique',
                ]
            )
        );

        //Validating that the input has an 'email' specific structure
        $validator->add(
            'email',
            new Email(
                [
                    'field'   => 'email',
                    'message' => 'The email address must be valid',
                ]
            )
        );

        //Validating that the 'name' field is not null or empty
        $validator->add(
            'name',
            new PresenceOf(
                [
                    'field'   => 'name',
                    'message' => 'You must enter a name',
                ]
            )
        );

        //Validating that the 'password' field is not null or empty
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