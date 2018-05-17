<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class UsersForm extends Form {

    public function initialize() {
        // name
        $name = new Text("name");
        $name->addValidators([
            new PresenceOf([
                "message" => "Name is required"
            ])
        ]);
        $this->add($name);

        // email
        $email = new Text("email");
        $email->addValidators([
            new PresenceOf([
                "message" => "Email is required"
            ]),
            new Email([
                'message' => 'E-mail is not valid'
            ])
        ]);
        $this->add($email);

        // password
        $password = new Password("password");
        $password->addValidators([
            new PresenceOf([
                'message' => 'Password is required'
            ])
        ]);
        $this->add($password);
    }
}