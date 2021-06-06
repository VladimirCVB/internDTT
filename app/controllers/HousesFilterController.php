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

            //Get the house_filter by house id
            $houseId = $this->request->getQuery('id');
            $houseFilter = Houses_filter::findFirst("house_id = '$houseId'");

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $houseFilter ]);

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

            // Init empty house_filter object
            $houseFilter = new Houses_filter();

            // Assign inputted data to empty object
            $houseFilter->assign(
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

            //Update the house filter data in the database and check for errors
            $message = $this->errorCheck($houseFilter);
            
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

    public function deleteAction()
    {
        // Check whether the request was made with method DELETE ( $this->request->isDelete() )
        if ($this->request->isDelete()) {

            //Get the house filter by house id
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
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

}

