<?php
declare(strict_types=1);

use Phalcon\Http\Request;

use App\Forms\RegisterForm;
use App\Forms\LoginForm;

class UserController extends ControllerBase
{

    public function onConstruct()
    {
        // $this->decksModel = new Decks();
    }

    public function initialize()
    {
        // $this->loginForm = new loginForm();
        // $this->usersModel = new Users();
        $decks = Decks::find();
        // echo count($decks);
    }

    public function indexAction()
    {

    }

    public function loginAction()
    {
        $this->tag->setTitle('Phalcon :: Login');
        $this->view->form = new LoginForm();
    }

    public function loginSubmitAction()
    {
        $user = new Users();
        $form = new LoginForm();

        if (!$this->request->isPost()){
            $this->flash->error('Invalid POST');
            return $this->response->redirect('user/login');
        }

        // if (!$this->security->checkToken()){
        //     $this->flash->error('Invalid token');
        //     return $this->response->redirect('user/login');
        // }

        $form->bind($_POST, $user);
        if(!$form->isValid()){
            foreach($form->getMessages() as $message){
                $this->flash->error('Form is not valid');
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action' => 'login',
                ]);
                return;
            }
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = Users::findFirst([
            'email = :email:',
            'bind' => [
                'email' => $email,
            ]
        ]);

        if ($user->active != 1) {
            $this->flash->error("User Deactivate");
            return $this->response->redirect('user/login');
        }

        if ($user) {
            if ($this->security->checkHash($password, $user->password))
            {

                // Set a session
                $this->session->set('AUTH_ID', $user->id);
                $this->session->set('AUTH_NAME', $user->name);
                $this->session->set('AUTH_EMAIL', $user->email);
                $this->session->set('AUTH_CREATED', $user->created);
                $this->session->set('AUTH_UPDATED', $user->updated);
                $this->session->set('IS_LOGIN', 1);

                $this->flash->success("Login Success");

                // $this->dispatcher->forward([
                //     'controller' => 'user',
                //     'action' => 'profile',
                //     'userID' => $user->id,
                // ]);

                // $this->dispatcher
                // return;
                // echo 'sukses<br>';
                // echo $user->name;
                // return;
                return $this->response->redirect('user/profile');
                // return;
            }
        } else {
            // To protect against timing attacks. Regardless of whether a user
            // exists or not, the script will take roughly the same amount as
            // it will always be computing a hash.
            // $this->flash->error("Wrong!");
            $this->security->hash(rand());
        }

        // The validation has failed
        $this->flash->error("Invalid login");
        return $this->response->redirect('user/login');
    }

    public function registerAction()
    {
        $this->tag->setTitle('Phalcon :: Register');
        $this->view->form = new RegisterForm();
    }

    public function registerSubmitAction()
    {
        // echo 'signup/register';
        $user = new Users();
        $form = new RegisterForm();

        if (!$this->request->isPost()){
            return $this->response->redirect('user/register');
        }

        $form->bind($_POST, $user);
        if(!$form->isValid()){
            foreach($form->getMessages() as $message){
                $this->flash->error('Form is not valid');
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action' => 'register',
                ]);
                return;
            }
        }

        $user->setPassword($this->security->hash($_POST['password']));

        $user->setActive(1);
        $user->setCreated(time());
        $user->setUpdated(time());

        if(!$user->save()){
            foreach($user->getMessages() as $m){
                $this->flash->error('email taken');
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action' => 'register',
                ]);
                return;
            }
        }

        $this->flash->success('THX 4 registering!');
        return $this->response->redirect('user/login');

        $this->view->disable();

    }

    public function profileAction()
    {

        $this->authorized();
        $decks = Decks::find([
            'conditions' => 'user_id = ?1',
            'bind' => [
                1 => $this->session->get('AUTH_ID'),
            ],
        ]);
        // echo count($decks);
        // foreach($decks as $deck){
        //     echo $deck->title, "\n";
        // }
        $this->view->decksData = $decks;
        // exit;
        // $userId = $this->dispatcher->getParam('userID');
        // echo $userId;
        // return;
        // return $this->response->redirect('user/register/' . $userId);
    }

    public function logoutAction()
    {
        # https://docs.phalconphp.com/en/3.3/session#remove-destroy

        // Destroy the whole session
        $this->session->destroy();
        return $this->response->redirect('user/login');
    }

}

