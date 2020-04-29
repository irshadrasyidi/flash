<?php
use Phalcon\Http\Request;

use App\Forms\CreateDeckForm;

class DeckController extends ControllerBase
{
    public $createDeckForm;
    public $deckModel;
    
    public function initialize()
    {

        $this->authorized();
        $this->createDeckForm = new CreateDeckForm();
        $this->deckModel = new Decks();
    }


    public function createAction()
    {

        $this->tag->setTitle('Phalcon :: Add Deck');

        $this->view->form = new CreateDeckForm();
    }

    public function createSubmitAction()
    {
        
        if (!$this->request->isPost()) {
            return $this->response->redirect('user/login');
        }


        $this->createDeckForm->bind($_POST, $this->deckModel);

        if (!$this->createDeckForm->isValid()) {
            foreach ($this->createDeckForm->getMessages() as $message) {
                $this->flash->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'create',
                ]);
                return;
            }
        }


        // if ($this->request->getPost('create') != NULL) {
        //     $this->deckModel->setIsPublic(1);
        // }
        
        // PENTING!
        // Set User ID
        $this->deckModel->setUserId($this->session->get('AUTH_ID'));

        if (!$this->deckModel->save()) {
            foreach ($this->deckModel->getMessages() as $m) {
                $this->flash->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'create',
                ]);
                return;
            }
        }

        $this->flash->success('Deck created');
        return $this->response->redirect('user/profile');

        $this->view->disable();
    }

    public function deleteAction($deckId)
    {
        // $id = (int)$deckId;

        $conditions = ['id'=>$deckId];
        $deck = Decks::findFirst([
            'conditions' => 'id=:id:',
            'bind' => $conditions,
        ]);
        if ($deck->delete() === false) {
            $messages = $deck->getMessages();
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        } else {
            return $this->response->redirect('user/profile');
        }
    }

}