<?php

// use Phalcon\Mvc\Controller;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $user = Users::findFirst(1);
        // $user->name = $user->name."_m";
        // $user->save();

        // $user_foundBy_email = Users::find("email = 'koto'");
        // $user_foundBy_email = Users::findFirst(
        $user_foundBy_email = Users::find(
            [
                // "conditions" => "email = 'gmail'",
                "conditions" => "email LIKE '%gmail%'",
            ]
        );

        $this->view->setVar("user", $user);
        $this->view->setVar("user_foundBy_email", $user_foundBy_email);

        // var_dump($user_foundBy_email);
        // print_r($user_foundBy_email);
        // print_r(["a", "b"]);
        // exit;
        $new_user = new Users();
        $new_user->name = "suzuki_s";
        $new_user->email = "gmail";
        // $is_success = $new_user->save();

        if ($is_success) {
            echo "success!";
        } else {
            echo "failed";

            $msgs = $new_user->getMessages();

            foreach ($msgs as $msg) {
                echo $msg, "\n";
            }
        }
    }

}

