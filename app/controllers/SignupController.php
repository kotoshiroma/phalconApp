<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {

    }

    public function signUpAction()
    {
        $user = new Users();
        var_dump($this->request->getPost());
        // exit;

        // saveメソッドの仕様を確認すること
        $is_success = $user->save(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        if ($is_success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";
            $messages = $user->getMessage();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>"; //カンマでいいのか
                // echo $message->getMessage()."<br/>";
            }
        }

        $this->view->disable();
    }

    public function signIn_by_yahooIdAction() {







    }
}