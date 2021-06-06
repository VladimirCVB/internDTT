<?php
declare(strict_types=1);


use Phalcon\Di;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;


class HousesController extends ControllerBase
{
    public function getHouseAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get house by id and send response
            $houseId = $this->request->getQuery('id');
            $house = $this->getHouseByIdAction($houseId);
            
            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $house ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $this->response->setContent("Sorry, the page doesn't exist");
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function getHousesAllAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get all houses
            $house = Houses::find();

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $this->response->setContent("Sorry, the page doesn't exist");
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);

            //Send the response
            $this->response->send();
        }

        // Send response to the client
        return $house;
    }

    public function getHousesAllResponseAction()
    {
        //$this->request = $this -> getRequest();
        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            $houses = $this->getHousesAllAction();
            
            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $houses ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $this->response->setContent("Sorry, the page doesn't exist");
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function postAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isPost()) {

            $house = new Houses();

            //assign value from the form to $user
            $house->assign(
                $this->request->getPost(),
                [
                    'street',
                    'number',
                    'addition',
                    'zipcode',
                    'city'
                ]
            );

            // Store and check for errors
            $success = $house->save();

            if ($success) {
                $message = "Successfully created your new room!";
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
            // $this->response->setContent("Sorry, the page doesn't exist");
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function putAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isPut()) {

            //Get the id of the house
            $houseId = $this->request->getQuery('house_id');

            //Find house by id
            $house = Houses::findFirst("id='$houseId'");

            //Get the request data
            $this->requestData = $this->request->getPut();

            //Declare basic required data street, number, addition, zipcode, city
            $array = array("street", "number", "addition", "zipcode", "city");

            //Check if vars contain any data and update the house if data is passed from the form
            foreach($array as $a){
                if($this->requestData[$a] != '' || $this->requestData[$a] != null){
                    $house->$a = $this->requestData[$a];
                }
            }

            //Update the house in the database and check for errors
            $success = $house->update();

            //Save the message
            if ($success) {
                $message = "Successfully created your new room!";
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
            // $this->response->setContent("Sorry, the page doesn't exist");
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function deleteAction($houseId)
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isDelete()) {

            //Get the house by id
            $house = Houses::findFirst("id = '$houseId'");

            //Delete room data from the database
            $roomController = new RoomsController();
            $roomController -> deleteAction($houseId);

            //Delete the house from the database
            $house->delete();
            
            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => 'House is no longer in the database' ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $this->response->setContent("Sorry, the page doesn't exist");
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function getHouseByIdAction($id)
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get the house by id
            $house = Houses::findFirst("id = '$id'");

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $this->response->setContent("Sorry, the page doesn't exist");
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        return $house;
    }
}

