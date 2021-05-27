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

            $listings = Listings::find(); 

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

            $userId = $request->getQuery('id');
            $listings = Listings::find("user_id = '$userId'");

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

            $listingId = $request->getQuery('id');
            $listings = Listings::findFirst("id = '$listingId'");

            $listings->active = 0;

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

            $listingId = $request->getQuery('id');
            $listings = Listings::findFirst("id = '$listingId'");

            $listings->active = 0;
            //call delete controllers fro house and room
            
            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $user ]);

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
        $houseController = new HousesController();
        $housesData = $houseController -> getHousesAllAction();

        $array = array();

        for ($i = 0; $i < count($listings); $i++) {
            $listings[$i]->house_data = $houseController -> getHouseByIdAction($listings[$i]->house_id);
            $elementOne = $listings[$i];
            $array[] = $elementOne;
        }

        return $array;
    }

    //admin
    // public function getAllAction()
    // {
    //     return '<h1>Happy marriage</h1>';
    // }

    // public function getAllAction()
    // {
    //     return '<h1>Happy marriage</h1>';
    // }

}

