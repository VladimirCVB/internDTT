<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    // Common logic

    public function beforeExecuteRoute($dispatcher)
    {
        // Disable View File Content
        $this->view->disable();      
    }

    protected function errorCheck($object)
    {
        try
        {
            // Store and check for errors
            $success = $object->save();

            // Set default message
            $message = "Operation fully completed";

            if(!$success)
            {
                $message = "Sorry, the following problems were generated:<br>"
                        . implode('<br>', $object->getMessages());

                // Set status code
                $this->response->setStatusCode(400, 'Bad Request');

                // Set response message
                $this->response->setJsonContent(["status" => false, "error" => $message]);
            }

            return $message;

        } catch(Exception $e)
        {
            return $this->response->setJsonContent(["status" => false, "error" => "An error occurred"]);;
        }
        
    }
}
