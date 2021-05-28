<?php
declare(strict_types=1);

use Phalcon\Http\Response;
use Phalcon\Http\Request;
use Phalcon\Di;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;

class ListingsController extends \Phalcon\Mvc\Controller
{

    public function getAllAction()
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

            //Get all listings
            $listings = Listings::find(); 

            //Add house data to listing by house_id
            $array = $this->addHouseDataToListing($listings);

            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "listings" => $array]);

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

    public function getAllFilterAction()
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

            //Manual SQL input code
            // $userId = $request->getPost();
            // $query     = $this
            //     ->modelsManager
            //     ->createQuery(
            //         'SELECT * FROM Users WHERE id = :id:'
            //     )
            // ;
    
            // $users = $query->execute(
            //     [
            //         'id' => $userId,
            //     ]
            // );

            //Get listings by user_id
            $userId = $request->getQuery('id');
            $listings = Listings::find("user_id = '$userId'");

            //Add house data to listings by house_id
            $array = $this->addHouseDataToListing($listings);

            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $array ]);

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

            $listing = new Listings();

            //assign value from the form to $user
            $listing->assign(
                $this->request->getPost(),
                [
                    'user_id',
                    'house_id',
                    'post_date',
                    'active'
                ]
            );

            // Store and check for errors
            $success = $listing->save();

            if ($success) {
                $message = "Your listing was posted";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $listing->getMessages());
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

            //Get the id of the listing
            $listingId = $request->getQuery('id');

            //Find the listing by id
            $listings = Listings::findFirst("id = '$listingId'");

            //Set the listing to 'inactive' or active=false
            $listings->active = 0;

            //Update the listing in the database
            $listings->update();
            
            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $listings ]);

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

    public function deleteAction()
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

            //Get the id of the listing
            $listingId = $request->getQuery('id');

            //Find the listing by id
            $listings = Listings::findFirst("id = '$listingId'");

            //Set the listing to 'inactive' or active=false
            $listings->active = 0;

            //Delete house and room data from the database
            $houseController = new HousesController();
            $houseController -> deleteAction($listings->house_id);

            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => "Success" ]);

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

    private function addHouseDataToListing($listings){

        //Create new HousesController
        $houseController = new HousesController();

        //Create new HousesController
        $roomsController = new RoomsController();

        //Decalre empty array to store data
        $array = array();

        //Iterate through all listing and append matching house data by house_id
        for ($i = 0; $i < count($listings); $i++) {
            
            //Adding house data to listing
            $listings[$i]->house_data = $houseController -> getHouseByIdAction($listings[$i]->house_id);

            //Checking if any house data has been found for the listing
            if($listings[$i]->house_data == null)
            continue;
            
            //Adding room data to the house in the listing
            $listings[$i]->house_data->rooms = $roomsController -> getRoomAction($listings[$i]->house_id);

            //Saving changes to another variable
            $elementOne = $listings[$i];

            //Adding the variable to an array
            $array[] = $elementOne;
        }

        //Returning the listings with house and room data
        return $array;
    }
}

