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

    public function editAction($deckId)
    {
        if (!$this->request->isPost()) {

            $deck = Decks::findFirstById($deckId);
            if (!$deck) {
                $this->flash->error("Deck not found");
    
                return $this->forward("user/profile");
            }
            $this->session->set('DECK_ON', $deck->id);
            $this->view->form = new CreateDeckForm($deck, array('edit' => true));
        }

    }

    public function editSubmitAction()
    {
        // echo "edited";
        // exit;
        $this->createDeckForm->bind($_POST, $this->deckModel);

        if (!$this->createDeckForm->isValid()) {
            foreach ($this->createDeckForm->getMessages() as $message) {
                $this->flash->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'edit',
                ]);
                return;
            }
        }

        $this->deckModel->setId($this->session->get('DECK_ON'));
        $this->deckModel->setUserId($this->session->get('AUTH_ID'));

        if (!$this->deckModel->save()) {
            foreach ($this->deckModel->getMessages() as $m) {
                $this->flash->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'edit',
                ]);
                return;
            }
        }

        $this->flash->success('Deck created');
        return $this->response->redirect('user/profile');

        $this->view->disable();
    }

    public function learnAction($deckId)
    {

        $deck = Decks::findFirstById($deckId);

        $currentCard = Cards::findFirst([
            'conditions' => 'user_id = ?1 AND deck_id = ?2 AND time =?3',
            'bind' => [
                1 => $this->session->get('AUTH_ID'),
                2 => $deck->id,
                3 => 0
            ],
        ]);


        // $this->view->currentCard = Cards::findFirst("time = 0");
        $this->view->currentCard = $currentCard;

        // $tes = Cards::findFirst([
        //     'conditions' => 'user_id = ?1 AND deck_id = ?2 AND time =?3',
        //     'bind' => [
        //         1 => $this->session->get('AUTH_ID'),
        //         2 => $deck->id,
        //         3 => 0
        //     ],
        // ]);

        $this->view->deck = $deck;

        // exit;
        $this->view->pick('deck/learn');
        
    }

    public function revealAction($deckId, $cardId)
    {

        $deck = Decks::findFirstById($deckId);

        $this->view->currentCard = Cards::findFirstById($cardId);

        $this->view->cardData = $card;

        // echo $deckId;
        $this->view->deckData = $deck;
        // $this->view->cardsData = $cards;
        // $this->view->cards2playData = $cards2play;
        

        // echo $cards2play[2]->frontside;
        // exit;
        $this->view->pick('deck/reveal');
        
    }

    public function diffTimeAction($deckId, $cardId)
    {
        echo "DIFTIM";
        echo $deckId;
        echo "<br>";
        echo $cardId;
        echo "<br>";

        $card = Cards::findFirstById($cardId);

        echo $_POST["diff"];
        echo "<br>";
        echo $_POST["time"];

        $card->difficulty = $_POST["diff"];
        $card->time = $_POST["time"];
        $card->save();

        $this->dispatcher->forward([
            'controller' => 'deck',
            'action'     => 'learn',
        ]);

        // $servername = "localhost";
        // $username = "root";
        // $password = "Ed4nbener";
        // $dbname = "flash";

        // $conn = new mysqli($servername, $username, $password, $dbname);

        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }

        // $sql = "UPDATE `flash`.`cards` SET `time` = $weight WHERE (`id` = $cardId);";

        // echo $card->id;

        // $card->assign(array(
        //     'time' => $time,

        // ));

        // echo $deckId;
        // $this->view->deck = $deck;
        // $this->view->cardsData = $cards;
        // exit;
        $this->view->pick('deck/learn');
        
    }


}