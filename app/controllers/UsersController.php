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
            $users = Users::find();

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $users ]);

        } else {

            // Set status code
            $this->response->setStatusCode(405, 'Method Not Allowed');

            // Set the content of the response
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }

    public function getUserByIdAction()
    {
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isGet()) {

            //Request to get user by id
            $userId = $this->request->getQuery('id');
            $user = Users::findFirstById($userId);

            // Set status code
            $this->response->setStatusCode(200, 'OK');

            // Set the content of the response
            $this->response->setJsonContent(["status" => true, "error" => false, "data" => $user ]);

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

            $user = new Users();

            //Assign value from the form to $user
            $user->assign(
                $this->request->getPost(),
                [
                    'name',
                    'email',
                    'password',
                    'user_type',
                ]
            );

            //Decalring the security variable
            $security = new Security();

            //Getting the password from the request
            $password = $this->request->getPost('password', 'string');

            //Hash the password
            $user->password = $this->security->hash($password);

            //Save the user and check for errors
            $message = $this->errorCheck($user);

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
        // Check whether the request was made with method GET ( $this->request->isGet() )
        if ($this->request->isPut()) {
            //Get the id of the user
            $userId = $this->request->getQuery('id');

            //Find user by id
            $user = Users::findFirstById($userId);

            //Get the request data
            $this->requestData = $this->request->getPut();

            //Declare basic required data name and password
            $propertiesToUpdate = array("name", "password");

            //Check if variables contain any data and update the user information if data is passed from the form
            foreach($propertiesToUpdate as $property => $pro){
                if($this->requestData[$pro] != '' || $this->requestData[$pro] != null){

                    $user->$pro = $this->requestData[$pro];

                    //Find the password property
                    if ($property === array_key_last($propertiesToUpdate))
                    {
                        //Decalring the security variable
                        $security = new Security();

                        //Hash the password
                        $user->$pro = $this->security->hash($this->requestData[$pro]);
                    }
                }
            }

            //Update the user data in the database and check for errors
            $message = $this->errorCheck($user);
            
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

            //Get the id of the user
            $userId = $this->request->getQuery('id');

            //Find user by id
            $user = Users::findFirstById($userId);

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
            $this->response->setJsonContent(["status" => false, "error" => "Method Not Allowed"]);
        }

        // Send response to the client
        $this->response->send();
    }
}

