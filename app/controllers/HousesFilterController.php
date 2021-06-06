<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;

class HousesFilterController extends ControllerBase
{

    public function getHouseFilterAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Get the room by house id
            $houseId = $this->request->getQuery('id');
            $houseFIlter = Houses_filter::findFirst("house_id = '$houseId'");

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $houseFIlter ]);

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

            $houseFIlter = new Houses_filter();

            //assign value from the form to $user
            $houseFIlter->assign(
                $this->request->getPost(),
                [
                    'house_id',
                    'livings_count',
                    'bedr_count',
                    'toilets_count',
                    'storages_count',
                    'barths_count',
                    'total_count'
                ]
            );

            // Store and check for errors
            $success = $houseFIlter->save();

            if ($success) {
                $message = "Successfully created your new room!";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $houseFIlter->getMessages());
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

    public function deleteAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isDelete()) {

            //Get the room by house id
            $houseId = $this->request->getQuery('house_id');
            $houseFilter = Houses_filter::findFirst("house_id = '$houseId'");

            //Delete house from db
            $houseFilter->delete();
            
            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => 'House filter is no longer in the database' ]);

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

}

