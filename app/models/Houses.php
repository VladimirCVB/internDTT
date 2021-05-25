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

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'number',
            new Digit(
                [
                    'field'   => 'number',
                    'message' => 'You must enter a numeric values for this field',
                ]
            )
        );

        $validator->add(
            'street',
            new PresenceOf(
                [
                    'field'   => 'street',
                    'message' => 'You must enter a value before submitting the form',
                ]
            )
        );

        $validator->add(
            'zipcode',
            new PresenceOf(
                [
                    'field'   => 'zipcode',
                    'message' => 'You must enter a value before submitting the form',
                ]
            )
        );

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