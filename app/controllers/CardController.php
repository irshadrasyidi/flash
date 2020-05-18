<?php
use Phalcon\Http\Request;

use App\Forms\CreateCardForm;

class CardController extends ControllerBase
{
    public $createDeckForm;
    public $deckModel;
    public $cardModel;
    
    public function indexAction()
    {
        $card = Cards::find();
        $this->view->title = "Manage Cards";
        $this->view->cards = $cards;
    }

    public function initialize()
    {

        $this->authorized();
        $this->createCardForm = new CreateCardForm();
        $this->deckModel = new Decks();
        $this->cardModel = new Cards();
    }


    public function createAction()
    {
        $this->tag->setTitle('Phalcon :: Add Deck');

        $this->view->form = new CreateCardForm();
    }

    public function createSubmitAction()
    {

        $this->createCardForm->bind($_POST, $this->cardModel);

        if (!$this->createCardForm->isValid()) {
            foreach ($this->createCardForm->getMessages() as $message) {
                $this->flash->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'create',
                ]);
                return;
            }
        }
        
        // // PENTING!
        // // Set User ID
        // var_dump($this->session->get('AUTH_ID'));
        $this->cardModel->setUserId($this->session->get('AUTH_ID'));
        $this->cardModel->setDeckId($this->session->get('DECK_ON'));
        $this->cardModel->setTime(0);

        if (!$this->cardModel->save()) {
            foreach ($this->cardModel->getMessages() as $m) {
                $this->flash->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'create',
                ]);
                return;
            }
        }

        $this->flash->success('Card created');
        return $this->response->redirect('user/profile/deck/'.$this->cardModel->getDeckId());

    }

    public function deleteAction($cardId)
    {

        $conditions = ['id'=>$cardId];
        $card = Cards::findFirst([
            'conditions' => 'id=:id:',
            'bind' => $conditions,
        ]);
        if ($card->delete() === false) {
            $messages = $card->getMessages();
            foreach ($messages as $message) {
                $this->flash->error($message);
            }
        } else {
            return $this->response->redirect('user/profile/deck/'.$this->session->get('DECK_ON'));
        }
    }

    public function showAction($deckId)
    {

        $this->authorized();
        
        $conditions = ['id'=>$deckId];
        $deck = Decks::findFirst([
            'conditions' => 'id=:id:',
            'bind' => $conditions,
        ]);

        $cards = Cards::find([
            'conditions' => 'user_id = ?1 AND deck_id = ?2',
            'bind' => [
                1 => $this->session->get('AUTH_ID'),
                2 => $deck->id,
            ],
        ]);

        $this->session->set('DECK_ON', $deck->id);

        $this->view->title = "Phalcon - Deck";
        $this->view->deck = $deck;
        $this->view->cardsData = $cards;

        $this->view->pick('card/show');

    }

    public function openAction($deckId, $cardId)
    {

        $this->authorized();

        $conditions = ['idDeck'=>$deckId, 'idCard'=>$cardId];
        
        $card = Cards::find([
            'conditions' => 'user_id = ?1 AND deck_id = ?2 AND id = ?3',
            'bind' => [
                1 => $this->session->get('AUTH_ID'),
                2 => $this->session->get('DECK_ON'),
                3 => $cardId,
            ],
        ]);

        $this->view->cardsData = $card;

    }

    public function editAction($cardId)
    {
        if (!$this->request->isPost()) {

            $card = Cards::findFirstById($cardId);
            if (!$card) {
                $this->flash->error("Deck not found");
    
                return $this->forward("user/profile");
            }
            $this->session->set('CARD_ON', $card->id);
            $this->view->form = new CreateCardForm($card, array('edit' => true));
        }

    }

    public function editSubmitAction()
    {
        // echo "edited";
        // exit;
        $this->createCardForm->bind($_POST, $this->cardModel);

        if (!$this->createCardForm->isValid()) {
            foreach ($this->createCardForm->getMessages() as $message) {
                $this->flash->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'edit',
                ]);
                return;
            }
        }

        $this->cardModel->setId($this->session->get('CARD_ON'));
        $this->cardModel->setDeckId($this->session->get('DECK_ON'));
        $this->cardModel->setUserId($this->session->get('AUTH_ID'));

        if (!$this->cardModel->save()) {
            foreach ($this->cardModel->getMessages() as $m) {
                $this->flash->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'edit',
                ]);
                return;
            }
        }

        $this->flash->success('Card created');
        return $this->response->redirect('user/profile/deck/'.$this->session->get('DECK_ON'));

        $this->view->disable();
    }

}