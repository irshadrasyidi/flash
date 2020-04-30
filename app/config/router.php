<?php

$router = $di->getRouter();

// Define your routes here
$router->add('/',
[
    'controller' => 'index',
    'action' => 'index',
]);

$router->add('/user/login',
[
    'controller' => 'user',
    'action' => 'login',
]);

$router->add('/user/login/submit',
[
    'controller' => 'user',
    'action' => 'loginSubmit',
]);

$router->add('/user/register',
[
    'controller' => 'user',
    'action' => 'register',
]);

$router->add('/user/register/submit',
[
    'controller' => 'user',
    'action' => 'registerSubmit',
]);

$router->add('/user/profile',
[
    'controller' => 'user',
    'action' => 'profile',
]);

$router->add('/user/logout',
[
    'controller' => 'user',
    'action' => 'logout',
]);

$router->add('/deck/create',
[
    'controller' => 'deck',
    'action' => 'create',
]);

$router->add('/deck/create/submit',
[
    'controller' => 'deck',
    'action' => 'createSubmit',
]);

$router->add('/deck/delete/{id}',
[
    'controller' => 'deck',
    'action' => 'delete',
]);

$router->add('/user/profile/deck/{id}',
[
    'controller' => 'card',
    'action' => 'show',
]);

$router->add('/card/create/',
[
    'controller' => 'card',
    'action' => 'create',
]);

$router->add('/card/create/submit',
[
    'controller' => 'card',
    'action' => 'createSubmit',
]);

$router->add('/card/delete/{id}',
[
    'controller' => 'card',
    'action' => 'delete',
]);

$router->add('/user/profile/deck/{idDeck}/card/{idCard}',
[
    'controller' => 'card',
    'action' => 'open',
]);

$router->add('/deck/edit/{id}',
[
    'controller' => 'deck',
    'action' => 'edit',
]);

$router->add('/deck/edit/submit',
[
    'controller' => 'deck',
    'action' => 'editSubmit',
]);

$router->add('/card/edit/{id}',
[
    'controller' => 'card',
    'action' => 'edit',
]);

$router->add('/card/edit/submit',
[
    'controller' => 'card',
    'action' => 'editSubmit',
]);

$router->handle($_SERVER['REQUEST_URI']);
