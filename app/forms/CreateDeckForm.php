<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf;

class CreateDeckForm extends Form
{
    public function initialize()
    {

        $title = new Text(
            'title',
            [
                "class" => "form-control",
                "placeholder" => "Enter Deck Title"
            ]
        );

        $title->addValidators([
            new PresenceOf(['message' => 'The title is required']),
        ]);

        $create = new Submit(
            'create',
            [
                "name" => "create",
                "value" => "create",
                "class" => "btn btn-primary"
            ]
        );

        $this->add($title);
        $this->add($create);

    }
}