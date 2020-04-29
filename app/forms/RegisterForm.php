<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;

class RegisterForm extends Form
{
    public function initialize()
    {
        $name = new Text(
            'name',
            [
                "class" => "form-control",
                "placeholder" => "Enter name"
            ]
        );

        $name->addValidator(
            new PresenceOf(['message' => 'The name is required'])
        );

        $email = new Text(
            'email',
            [
                "class" => "form-control",
                "placeholder" => "Enter email"
            ]
        );

        $email->addValidators([
            new PresenceOf(['message' => 'The name is required']),
            new Email(['message' => 'The email is not valid']),
        ]);

        $password = new Password(
            'password',
            [
                "class" => "form-control",
                "placeholder" => "Enter Password"
            ]
        );

        $password->addValidators([
            new PresenceOf(['message' => 'Password required']),
            new StringLength(['min' => 1, 'message' => 'Password too short']),
            new Confirmation(['with' => 'password_confirm', 'message' => 'Password doesnt match confirm']),
        ]);

        $passwordConf = new Password(
            'password_confirm',
            [
                "class" => "form-control",
                "placeholder" => "Enter Password"
            ]
        );

        $passwordConf->addValidator(
            new PresenceOf(['message' => 'conf Password required']),
        );

        $submit = new Submit(
            'submit',
            [
                "value" => "Register",
                "class" => "btn btn-primary"
            ]
        );

        $this->add($name);
        $this->add($email);
        $this->add($password);
        $this->add($passwordConf);
        $this->add($submit);

    }
}