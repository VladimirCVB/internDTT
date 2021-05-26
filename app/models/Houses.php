<?php

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Digit;

class Houses extends Model
{
    public $id;
    public $street;
    public $number;
    public $addition;
    public $zipcode;
    public $city;

    //Adding validator for specific fields
    public function validation()
    {
        $validator = new Validation();

        //Validating 'number' field to only contain digits
        $validator->add(
            'number',
            new Digit(
                [
                    'field'   => 'number',
                    'message' => 'You must enter a numeric values for this field',
                ]
            )
        );

        //Validating 'street' field to not be null or empty
        $validator->add(
            'street',
            new PresenceOf(
                [
                    'field'   => 'street',
                    'message' => 'You must enter a value before submitting the form',
                ]
            )
        );

        //Validating 'zipcode' field to not be null or empty
        $validator->add(
            'zipcode',
            new PresenceOf(
                [
                    'field'   => 'zipcode',
                    'message' => 'You must enter a value before submitting the form',
                ]
            )
        );

        //Validating 'city' field to not be null or empty
        $validator->add(
            'city',
            new PresenceOf(
                [
                    'field'   => 'city',
                    'message' => 'You must enter a value before submitting the form',
                ]
            )
        );
        
        // Validate the validator
        return $this->validate($validator);
    }
}