<?php

namespace Controllers;

use Psr\Container\ContainerInterface;
use App\Ami;

class QueueController{

    protected $container;
    
    public function __construct( ContainerInterface $container ) {
		$this->container = $container;
    }
    
    function getQueueStatus($request, $response, $args) {

        $queuename = $args['queuename'];

        $ami = new Ami();

        $command  = [
            "Action" =>"QueueStatus",
            "ActionID"=> "1234",
            "Queue" => "{$queuename}"
        ];
        $events = [
            "QueueParams",
            "QueueMember",
            "QueueEntry" 
        ];

        $queueStatus = json_encode( $ami->sendAction( $command, $events ), JSON_PRETTY_PRINT);
        $response->getBody()->write( $queueStatus );
    
        return $response; 
    }

}