<?php

namespace Controllers;

use Psr\Container\ContainerInterface;

use Models\Queue;

class QueueController{

    protected $container;
    public $queue = [];
    
    public function __construct( ContainerInterface $container ) {
		$this->container = $container;
    }
    
    function getQueueStatus($request, $response, $args) {

        $queue = new Queue();
        $queueStatus = json_encode( $queue->getQueueStatus(), JSON_PRETTY_PRINT);
        $response->getBody()->write( $queueStatus );
    
        return $response;
    }

    public function putCallWait() {


    }

}