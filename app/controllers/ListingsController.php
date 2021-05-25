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

            // Check whether the request was made with Ajax ( $request->isAjax() )

            // Use Model for database Query
            $returnData = [
                "name" => "Gay",
                "youtube" => "https://www.youtube.com/channel/UCfd4AN4UKiWyHDdq-fizQGA"
            ];

            // Set status code
            $response->setStatusCode(200, 'OK');

            // Set the content of the response
            $response->setJsonContent(["status" => true, "error" => false, "data" => $returnData ]);

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

        $this->view->disable();

        $response = new Response();
        $request = new Request();

        $userId = $this->request->getQuery('id', 'int');
        $query     = $this
            ->modelsManager
            ->createQuery(
                'SELECT * FROM Users WHERE id = :id:'
            )
        ;

        $users = $query->execute(
            [
                'id' => $userId,
            ]
        );

        // $query = $this
        //     ->modelsManager
        //     ->createQuery(
        //         'SELECT * FROM users'
        //     )
        // ;

        // $users = $query->execute();

        $response->setStatusCode(200, 'OK');

        // Set the content of the response
        $response->setJsonContent(["status" => true, "error" => false, "data" => $users ]);
        $response->send();
    }

    public function postAction()
    {
        return '<h1>Happy marriage</h1>';
    }

    public function putAction()
    {
        return '<h1>Happy marriage</h1>';
    }

    public function deleteAction()
    {
        return '<h1>Happy marriage</h1>';
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

