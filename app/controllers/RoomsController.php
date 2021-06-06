<?php
declare(strict_types=1);

use Phalcon\Http\Response;
use Phalcon\Http\Request;
use Phalcon\Di;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;

class RoomsController extends ControllerBase
{

    public function getRoomAction($houseId)
    {
        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isGet()) {

            //Get the room by house id
            try{
                $room = Rooms::find("house_id = '$houseId'");
            } catch(Exception $e){
                $room = null;
            }

        } else {

            // Set status code
            $response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $response->setContent("Sorry, the page doesn't exist");
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        return $room;
    }

    public function postAction()
    {
        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isPost()) {

            $room = new Rooms();

            //assign value from the form to $user
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
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $message ]);

        } else {

            // Set status code
            $response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $response->setContent("Sorry, the page doesn't exist");
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $response->send();
    }

    public function putAction()
    {
        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        if ($request->isPut()) {

            //Get the id of the house
            $roomId = $request->getQuery('room_id');

            //Find house by id
            $room = Rooms::findFirst("id='$roomId'");

            //Get the request data
            $requestData = $request->getPut();

            //Declare basic required data
            $array = array("room_type", "width", "length", "height");

            //Check if vars contain any data and update the house if data is passed from the form
            foreach($array as $a){
                if($requestData[$a] != '' || $requestData[$a] != null){
                    $room->$a = $requestData[$a];
                }
            }

            //Update the house in the database and check for errors
            $success = $room->update();

            //Save the message
            if ($success) {
                $message = "Successfully updated your room!";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $house->getMessages());
            }

            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $message ]);

        } else {

            // Set status code
            $response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $response->setContent("Sorry, the page doesn't exist");
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $response->send();
    }

    public function deleteAction($houseId)
    {
        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isDelete()) {

            //Get the room by house id
            $rooms = Rooms::find("house_id = '$houseId'");

            //Delete rooms from db
            foreach ($rooms as $room) {
                $room->delete();
            }
            
            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => 'Rooms are no longer in the database' ]);

        } else {

            // Set status code
            $response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $response->setContent("Sorry, the page doesn't exist");
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $response->send();
    }

}

