<?php
declare(strict_types=1);

use Phalcon\Http\Response;
use Phalcon\Http\Request;
use Phalcon\Di;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;

class HousesController extends \Phalcon\Mvc\Controller
{
    public function getHouseAction()
    {
        // Disable View File Content
        $this->view->disable();

        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isGet()) {

            //Get house by id and send response
            $houseId = $request->getQuery('id');
            $house = $this->getHouseByIdAction($houseId);
            
            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $house ]);

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

    public function getHousesAllAction()
    {
        // Disable View File Content
        $this->view->disable();

        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isGet()) {

            //Get all houses
            $house = Houses::find();

        } else {

            // Set status code
            $response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $response->setContent("Sorry, the page doesn't exist");
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);

            //Send the response
            $response->send();
        }

        // Send response to the client
        return $house;
    }

    public function getHousesAllResponseAction()
    {
        // Disable View File Content
        $this->view->disable();

        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isGet()) {

            $houses = $this->getHousesAllAction();
            
            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $houses ]);

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

    public function postAction()
    {
        // Disable View File Content
        $this->view->disable();

        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isPost()) {

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
        // Disable View File Content
        $this->view->disable();

        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isPut()) {

            //Get the id of the house
            $houseId = $request->getQuery('house_id');

            //Find house by id
            $house = Houses::findFirst("id='$houseId'");

            //Get the request data
            $requestData = $request->getPut();

            //Declare basic required data street, number, addition, zipcode, city
            $array = array("street", "number", "addition", "zipcode", "city");

            //Check if vars contain any data and update the house if data is passed from the form
            foreach($array as $a){
                if($requestData[$a] != '' || $requestData[$a] != null){
                    $house->$a = $requestData[$a];
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
        // Disable View File Content
        $this->view->disable();

        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isDelete()) {

            //Get the house by id
            $house = Houses::findFirst("id = '$houseId'");

            //Delete room data from the database
            $roomController = new RoomsController();
            $roomController -> deleteAction($houseId);

            //Delete the house from the database
            $house->delete();
            
            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => 'House is no longer in the database' ]);

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

    public function getHouseByIdAction($id)
    {
        // Disable View File Content
        $this->view->disable();

        // Getting a response instance
        // https://docs.phalcon.io/3.4/en/response.html
        $response = new Response();

        // Getting a request instance
        // https://docs.phalcon.io/3.4/en/request
        $request = new Request();

        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($request->isGet()) {

            //Get the house by id
            $house = Houses::findFirst("id = '$id'");

        } else {

            // Set status code
            $response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            // $response->setContent("Sorry, the page doesn't exist");
            $response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        return $house;
    }

}

