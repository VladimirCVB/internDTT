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
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function getHousesAllAction()
    {
        //Init empty house object
        $house = new Houses();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get all houses
            $house = Houses::find();
        }

        // Return array
        return $house;
    }

    public function getHousesAllResponseAction()
    {
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
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function postAction()
    {
        // Check whether the request was made with method POST ( $this->request->isPost() )
        if ($this->request->isPost()) {

            // Init new empty house object
            $house = new Houses();

            // Assign inputted values to the house object
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

            //Update the house data in the database and check for errors
            $message = $this->errorCheck($house);
            
            //If there were errors during the save process, the response will contain a message with all of the errors
            if($message != "Operation fully completed")
            {
                $this->response->send();
                return;
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
        // Check whether the request was made with method PUT ( $this->request->isPut() )
        if ($this->request->isPut()) {

            //Get the id of the house
            $houseId = $this->request->getQuery('house_id');

            //Find the house by id
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

            //Update the house data in the database and check for errors
            $message = $this->errorCheck($house);
            
            //If there were errors during the save process, the response will contain a message with all of the errors
            if($message != "Operation fully completed")
            {
                $this->response->send();
                return;
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

            //Get the house by id
            $house = Houses::findFirstById($houseId);

            //Delete room data from the database
            $roomController = new RoomsController();
            if(!$roomController -> deleteAction($houseId))
                return false;

            //Delete the house from the database
            $house->delete();

        } else {

            // Send status to ListingsController
            return false;
        }

        // Send status to ListingsController
        return true;
    }

    public function getHouseByIdAction($id)
    {
        //Init empty house object
        $house = new Houses();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get the house by id
            $house = Houses::findFirstById($id);
        }

        // Return array type 
        return $house;
    }
}

