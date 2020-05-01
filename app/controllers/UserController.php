<?php
declare(strict_types=1);

use Phalcon\Http\Request;

use App\Forms\RegisterForm;
use App\Forms\LoginForm;

class UserController extends ControllerBase
{

    public function initialize()
    {

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

                // Set session
                $this->session->set('AUTH_ID', $user->id);
                $this->session->set('AUTH_NAME', $user->name);
                $this->session->set('AUTH_EMAIL', $user->email);
                $this->session->set('AUTH_CREATED', $user->created);
                $this->session->set('AUTH_UPDATED', $user->updated);
                $this->session->set('IS_LOGIN', 1);

                $this->flash->success("Login Success");

                return $this->response->redirect('user/profile');
                // return;
            }
        } else {

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

        $this->flash->success('Registration success!');
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

        $this->view->decksData = $decks;

    }

    public function logoutAction()
    {
        # https://docs.phalconphp.com/en/3.3/session#remove-destroy

        // Destroy the whole session
        $this->session->destroy();
        return $this->response->redirect('/');
    }

}

