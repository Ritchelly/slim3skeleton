<?php

use Slim\App;
use Controllers\QueueController;
use Controllers\UsersController;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../vendor/autoload.php';

return function ( App $app ) {

    $app->get('/queue/{queuename}', QueueController::class.':getQueueStatus');
    $app->get('/users', UsersController::class.':getUsers');

};
