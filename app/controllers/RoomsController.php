<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;

class RoomsController extends ControllerBase
{

    public function getRoomAction($houseId)
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get the room by house id
            try{
                $room = Rooms::find("house_id = '$houseId'");
            } catch(Exception $e){
                //If no rooms with the specified id are found the variable 'room' is set to null
                $room = null;
            }

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        return $room;
    }

    public function postAction()
    {
        // Check whether the request was made with method POST ( $this->request->isPost() )
        if ($this->request->isPost()) {

            //Init the 'room' variable
            $room = new Rooms();

            //Assign inputted properties to the room
            $room->assign(
                $this->request->getPost(),
                [
                    'house_id',
                    'room_type',
                    'width',
                    'length',
                    'height'
                ]
            );

            // Store and check for errors
            $success = $room->save();

            if ($success) {
                $message = "Successfully created your new room!";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $room->getMessages());
            }

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $message ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function putAction()
    {
        if ($this->request->isPut()) {

            //Get the id of the room
            $roomId = $this->request->getQuery('room_id');

            //Find room by id
            $room = Rooms::findFirstById($roomId);

            //Get the request data
            $this->requestData = $this->request->getPut();

            //Declare basic required data
            $array = array("room_type", "width", "length", "height");

            //Check if vars contain any data and update the room if data is passed from the form
            foreach($array as $a){
                if($this->requestData[$a] != '' || $this->requestData[$a] != null){
                    $room->$a = $this->requestData[$a];
                }
            }

            //Update the room in the database and check for errors
            $success = $room->update();

            //Save the message
            if ($success) {
                $message = "Successfully updated your room!";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $house->getMessages());
            }

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $message ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function deleteAction($houseId)
    {
        // Check whether the request was made with method DELETE ( $this->request->isDelete() )
        if ($this->request->isDelete()) {

            //Get the room by house id
            $rooms = Rooms::find("house_id = '$houseId'");

            //Delete rooms from the database
            foreach ($rooms as $room) {
                $room->delete();
            }
            
            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => 'Rooms are no longer present in the database' ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

}

