<?php

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\InclusionIn;

class Rooms extends Model
{
    public $id;
    public $house_id;
    public $room_type;
    public $width;
    public $length;
    public $height;

    //Adding validator for specific fields
    public function validation()
    {
        $validator = new Validation();
        
        //Validating that the room type is of the types in the specified array
        $validator->add(
            "room_type",
            new InclusionIn(
                [
                    'room_type' => 'Room type must be of "living", "bedroom", "toilet", "storage", or "bathroom"',
                    'domain' => [
                        'living',
                        'bedroom',
                        'toilet',
                        'storage',
                        'bathroom'
                    ],
                ]
            )
        );

        //Validating that the width only contains digits
        $validator->add(
            'width',
            new Digit(
                [
                    'field'   => 'width',
                    'message' => 'You must enter a numeric values for this field',
                ]
            )
        );

        //Validating that the width only contains digits
        $validator->add(
            'length',
            new Digit(
                [
                    'field'   => 'length',
                    'message' => 'You must enter a numeric values for this field',
                ]
            )
        );

        //Validating that the width only contains digits
        $validator->add(
            'height',
            new Digit(
                [
                    'field'   => 'height',
                    'message' => 'You must enter a numeric values for this field',
                ]
            )
        );
        
        // Validate the validator
        return $this->validate($validator);
    }
}