<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf;

class CreateCardForm extends Form
{
    public function initialize()
    {

        $deckId = $this->dispatcher->getParam("deckId");

        $frontside = new Text(
            'frontside',
            [
                "class" => "form-control",
                "placeholder" => "Enter Word to guess"
            ]
        );

        $frontside->addValidators([
            new PresenceOf(['message' => 'required']),
        ]);

        $backside = new Text(
            'backside',
            [
                "class" => "form-control",
                "placeholder" => "Enter Answer"
            ]
        );

        $backside->addValidators([
            new PresenceOf(['message' => 'required']),
        ]);

        $difficulty = new Text(
            'difficulty',
            [
                "class" => "form-control",
                "placeholder" => "Enter Difficulty (1 - 3)"
            ]
        );

        $difficulty->addValidators([
            new PresenceOf(['message' => 'required']),
        ]);

        $create = new Submit(
            'create',
            [
                "name" => "create",
                "value" => "create",
                "class" => "btn btn-primary"
            ]
        );

        $this->add($frontside);
        $this->add($backside);
        $this->add($difficulty);
        $this->add($create);

    }
}