<?php

namespace Models;

use Psr\Container\ContainerInterface;
use App\Ami;

class Queue{

	protected $container;
	public $queue = [];
	
	public function __construct( ) {

	}
	
	function getQueueStatus( $events = [ "All" ]  ) {
		$ami = new Ami();

		$command  = [
			"Action" =>"QueueStatus",
			"ActionID"=> "1234",
		//	"Queue" => "{$queuename}"
			"Queue" => "callcenter"
		];
	
		return $ami->sendAction( $command, $events ); 
	}

	public function putCallWaiting( string $queueName, Array $callInfo ) {
		$this->queue[ $queueName ] ["CallsWaiting"][ $callInfo["Uniqueid"] ] = $callInfo;
	}

	public function delCallWaiting( string $queueName, $uniqueId ) {
		unset( $this->queue[ $queueName ] ["CallsWaiting"] [ $uniqueId ] );
	}

	public function getQueueCallsWaitingInformation() {
		return $this->getQueueStatus( [" QueueEntry "] );
	}

	public function getQueuesInformation() {
		return $this->queue;
	}

}