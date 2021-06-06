<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;

class ListingsController extends ControllerBase
{

    public function getAllAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get all listings
            $listings = Listings::find(); 

            //Add house data to listing by house_id
            $array = $this->addHouseDataToListing($listings);

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "listings" => $array]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function getByUserIdAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get listings by user_id
            $userId = $this->request->getQuery('id');
            $listings = Listings::find("user_id = '$userId'");

            //Add house data to listings by house_id
            $array = $this->addHouseDataToListing($listings);

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $array ]);

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

            // Init new empty listing object
            $listing = new Listings();

            // Assign inputted values to new listing
            $listing->assign(
                $this->request->getPost(),
                [
                    'user_id',
                    'house_id',
                    'post_date',
                    'active'
                ]
            );

            //Update the listing data in the database and check for errors
            $message = $this->errorCheck($listing);
            
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

            //Get the id of the listing
            $listingId = $this->request->getQuery('id');

            //Find the listing by id
            $listings = Listings::findFirstById($listingId);

            //Set the listing to 'inactive' or active=false
            $listings->active = 0;

            //Update the listing in the database
            $listings->update();
            
            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $listings ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function deleteAction()
    {
        // Check whether the request was made with method DELETE ( $this->request->isDelete() )
        if ($this->request->isDelete()) {

            //Get the id of the listing
            $listingId = $this->request->getQuery('id');

            //Find the listing by id
            $listings = Listings::findFirstById($listingId);

            //Set the listing to 'inactive' or active=false
            $listings->active = 0;

            //Delete house and room data from the database
            $houseController = new HousesController();
            $houseController -> deleteAction($listings->house_id);

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => "Success" ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
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

