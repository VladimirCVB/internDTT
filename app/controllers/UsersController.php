<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Security;

class UsersController extends ControllerBase
{

    public function getAllAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Request to get user by id
            $userId = $this->request->getQuery('id');
            $user = Users::findFirst("id = '$userId'");

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $user ]);

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

            $user = new Users();

            //assign value from the form to $user
            $user->assign(
                $this->request->getPost(),
                [
                    'name',
                    'email',
                    'user_type',
                ]
            );

            //Decalring the security variable
            $security = new Security();

            //Getting the password from the request
            $password = $this->request->getPost('password', 'string');

            //Hash password
            $user->password = $this->security->hash($password);

            // Store and check for errors
            $success = $user->save();

            if ($success) {
                $message = "Thanks for registering!";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $user->getMessages());
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
            //Get the id of the user
            $userId = $this->request->getQuery('id');

            //Find user by id
            $user = Users::findFirst("id='$userId'");

            //Get the request data
            $this->requestData = $this->request->getPut();

            //Declare basic required data street, number, addition, zipcode, city
            $array = array("name", "password");

            //Check if vars contain any data and update the house if data is passed from the form
            foreach($array as $a){
                if($this->requestData[$a] != '' || $this->requestData[$a] != null){
                    $house->$a = $this->requestData[$a];
                }
            }

            //Update the house in the database and check for errors
            $success = $user->update();

            //Save the message
            if ($success) {
                $message = "Successfully created your new room!";
            } else {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $user->getMessages());
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

            //Get the id of the user
            $userId = $this->request->getQuery('id');

            //Find user by id
            $user = Users::findFirst("id='$userId'");

            //Delete user from db
            $user->delete();
            
            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => 'User no longer in the database' ]);

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

