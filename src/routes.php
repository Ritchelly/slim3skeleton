<?php

use Slim\App;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Ami;

require '../vendor/autoload.php';

return function ( App $app ) {

    $app->get('/queue/{name}', function (Request $request, Response $response, array $args) {
        $name = $args['name'];

        $ami = new Ami();

        $command  = [
            "Action" =>"QueueStatus",
            "ActionID"=> "sdasda",
            "Queue" => "callcenter"
        ];

        $events = [
            "QueueMember", 
            "QueueParams"
        ];

        $rs = json_encode( $ami->sendAction($command,$events), JSON_PRETTY_PRINT);

        $response->getBody()->write($rs);
    
        return $response;
    });

    $app->get('/users', function (Request $request, Response $response, array $args) use($app) {

        $db = $app->getContainer()->get('db');
        $users = $db->table('user')->get();

        $response->getBody()->write($users);
        return $response;
    });

};
