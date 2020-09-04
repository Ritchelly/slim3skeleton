<?php

use Slim\App;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Ami;

require '../vendor/autoload.php';

return function ( App $app ) {

    $app->get('/queue/{queuename}', function (Request $request, Response $response, array $args) {
        $queuename = $args['queuename'];

        $ami = new Ami();

        $command  = [
            "Action" =>"QueueStatus",
            "ActionID"=> "1234",
            "Queue" => "{$queuename}"
        ];

        $events = [
            "QueueMember", 
            "QueueParams"
        ];

        $queueStatus = json_encode( $ami->sendAction($command,$events), JSON_PRETTY_PRINT);
        $response->getBody()->write($queueStatus);
    
        return $response;
    });

    $app->get('/users', function (Request $request, Response $response, array $args) use($app) {

        $db = $app->getContainer()->get('db');
        $users = $db->table('user')->get();

        $response->getBody()->write($users);
        return $response;
    });

};
