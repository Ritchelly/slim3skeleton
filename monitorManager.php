<?php

namespace App;

use Models\Agents;
use Models\Queue;

include 'vendor/autoload.php';

set_time_limit(0);

$webSocket = new WebSocket();
$ami = new Ami();
$queue = new Queue();
$agents = new Agents();

$webSocket->emit( "ami", [ $agents->getAgentsInformation() ] );
print_r($agents->getAgentsInformation());

$event = [
//	'All',
	'AgentLogin',
	'AgentLogoff',
	'AgentConnect',
	'AgentComplete',
	'DeviceStateChange',
	'QueueCallerAbandon',
	'QueueCallerJoin',
	'QueueCallerLeave',
	'QueueMemberPause',
	'QueueMemberAdded',
	'QueueMemberRemoved',
	'QueueMemberStatus',
	'QueueMember',
];

do {

	$amiEvent = $ami->getEvent($event);

	switch ( $amiEvent["Event"] ) {

		case "QueueCallerJoin":
			$queue->putCallWaiting(
				$amiEvent["Queue"],
				$amiEvent
			);

			$webSocket->emit( "ami", [ $agents->getAgentsInformation() ] );
		break;

		case "QueueCallerLeave":
			$queue->delCallWaiting(
				$amiEvent["Queue"],
				$amiEvent["Uniqueid"]
			);

			$webSocket->emit( "ami", [ $agents->getAgentsInformation() ] );
		break;

		case "AgentConnect":
			$agents->putAgentCall( 
				$amiEvent["Interface"],
				$amiEvent 
			);
			
			$webSocket->emit( "ami", [ $agents->getAgentsInformation() ] );
		break;

		case "AgentComplete":
			$agents->delAgentCall( 
				$amiEvent["Interface"]
			);

			$webSocket->emit( "ami", [ $agents->getAgentsInformation() ] );
		break;

		case "QueueMemberRemoved":
			$agents->removeAgentFromQueue(
				$amiEvent 
			);

			$webSocket->emit( "ami", [ $agents->getAgentsInformation() ] );
		break;

		case "QueueMemberPause":
		case "QueueMemberAdded":
		case "QueueMemberStatus":
			$agents->setAgentStatus(
				$amiEvent
			);

			$webSocket->emit( "ami", [ $agents->getAgentsInformation() ] );
		break;

		default:
		/* 	$amiEvent = $ami->getEvent($event);
			$webSocket->emit( "ami", [ $amiEvent ] );
			print_r($amiEvent);
		*/

		print_r($amiEvent).PHP_EOL;
		break;
	}
}
while ( Utils::check_asterisk_status() );
//utils::put_log("O asterisk parou de rodar");
?>
