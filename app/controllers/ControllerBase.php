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
}
