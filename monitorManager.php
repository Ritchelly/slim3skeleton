<?php

namespace App;

include 'vendor/autoload.php';

set_time_limit(0);

$webSocket = new WebSocket();
$ami = new Ami();

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
	'OriginateResponse',
	'DialBegin',
	'UserEvent',
	'Newexten',
	'Hangup',
	'BridgeEnter',
	'SoftHangupRequest',
	'Registry',
	'QueueMember' 
];

$queue = [];
$agents = [];

do {

	$amiEvent = $ami->getEvent($event);
	switch ( $amiEvent["Event"] ) {

		case "QueueCallerJoin":

			$queue = [
				$amiEvent["Queue"] => [
					"CallsWaiting" => [
						$amiEvent["Uniqueid"] => $amiEvent
					]
				]
			];

		break;

		case "QueueCallerLeave":
			unset( $queue[ $amiEvent["Queue"] ] ["CallsWaiting"] [ $amiEvent["Uniqueid"] ] );

		break;

		case "AgentConnect":
			$agents[$amiEvent["Interface"]] =  $amiEvent; 

		break;

		case "AgentComplete":
			$agents[$amiEvent["Interface"]] =  ''; 
			
		break;

		default:
		/* 	$amiEvent = $ami->getEvent($event);
			$webSocket->emit( "ami", [ $amiEvent ] );
			print_r($amiEvent);
			echo "=====================".PHP_EOL; */
			print_r( $amiEvent["Event"] );
			echo "=======Filas============";
			print_r($queue);
			echo "========================";
			echo "=======Agents===========";
			print_r($agents);
			echo "========================";

		break;
	}
}
while ( Utils::check_asterisk_status() );
//utils::put_log("O asterisk parou de rodar");
?>
