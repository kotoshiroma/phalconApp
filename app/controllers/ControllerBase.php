<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public $user;
    public $test = "s";

    // public function initialize() {
    public function beforeExecuteRoute() {
        // $this->view->user = $this->dispatcher->getParam("user");        
        //  $test= $user;
        // $this->view->user = $user;
        $this->view->user = $this->getUser();
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }
}
