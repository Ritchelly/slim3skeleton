<?php

namespace Models;

use Psr\Container\ContainerInterface;
use App\Ami;

class Queue{

	protected $container;
	public $queue = [];
	
	public function __construct( ) {

	}
	
	function getQueueStatus() {

		$ami = new Ami();

	 /*    $command  = [
			"Action" =>"QueueStatus",
			"ActionID"=> "1234",
			"Queue" => "{$queuename}"
		]; */
		$command  = [
			"Action" =>"QueueStatus",
			"ActionID"=> "1234",
			"Queue" => "callcenter"
		];
		$events = [
			"QueueParams",
			"QueueMember",
			"QueueEntry" 
		];
	
		return $ami->sendAction( $command, $events ); 
	}

	public function putCallWaiting( string $queueName, Array $callInfo ) {

		$this->queue = [
			$queueName => [
				"CallsWaiting" => [
					$callInfo["Uniqueid"] => $callInfo
				]
			]
		];
	}

	public function delCallWaiting( string $queueName, int $uniquedId ) {
			unset( $this->queue[ $queueName ] ["CallsWaiting"] [ $uniquedId ] );
	}

}