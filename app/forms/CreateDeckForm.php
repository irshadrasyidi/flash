<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;

use Phalcon\Validation\Validator\PresenceOf;

class CreateDeckForm extends Form
{
    public function initialize($entity = null, $options = [])
    {
        if(isset($options["edit"])){
            $id = new Hidden('id', [
                "required" => true,
            ]);

            $this->add($id);
        }

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
            'save',
            [
                "name" => "save",
                "value" => "save",
                "class" => "btn btn-primary"
            ]
        );

        $this->add($title);
        $this->add($create);

    }
}