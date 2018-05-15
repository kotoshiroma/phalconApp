<?php

// use Phalcon\Mvc\Controller;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $locale = Locale::acceptFromHttp($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        // echo $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        // echo $locale;
        $this->view->locale = $locale;
    }

}

