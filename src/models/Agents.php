<?php

namespace Models;

use Psr\Container\ContainerInterface;
use App\Ami;
use Models\Queue;

class Agents{

	public $agents = [];

	function __construct() {
		$queue = new Queue();
		$queueMembers = $queue->getQueueStatus( [ "QueueMember" ] );
		$this->handleQueueMembers( $queueMembers );

		return $queueMembers;
	}

	function handleQueueMembers( Array $queueMembers ) {

		foreach( $queueMembers as $agents ) {
			$this->agents[ $agents[ "StateInterface" ] ] [ "status" ] = $agents;
		}
	}

	public function putAgentCall( string $agentInterface, Array $callInfo ) {
		$this->agents[ $agentInterface ] ['callinfo'] = $callInfo;
	}

	public function delAgentCall( string $agentInterface ) {
		$this->agents[ $agentInterface ] ['callinfo'] = '';
	}

	public function setAgentStatus( Array $queueMemberStatus ) {
		$this->agents[ $queueMemberStatus['Interface'] ]["status"] = $queueMemberStatus;
	}

	public function removeAgentFromQueue( Array $queueMemberRemoved ) {
		unset( $this->agents[ $queueMemberRemoved['Interface'] ] );
	}

	public function getAgentsInformation( ) {
		return $this->agents;
	}

}