<?php
 	include("create.php");
    
	$req = $_GET['method'];

	switch ($req) {
		case 'addtoevent':
			$offtrade = $_GET['offtrade'];
			$games = $_GET['games'];
			$hash = $_GET['hash'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$table_name = $_GET['game'];
			if($table_name == 'dota') $table_name = 'event_dota';
			elseif ($table_name == 'csgo') $table_name = 'event_csgo';
			else $table_name = '';
			$obj = new DB_service();
			$obj->add_to_db($offtrade, $games, $hash, $ip, $table_name);
			break;
		case 'geteventinfo':
			$obj = new DB_service();
			$pardate = $obj->getDates();
			$datetime1 = new DateTime("now");
			$datetime2 = new DateTime(' '.$pardate.' 19:00:00');
			$interval = $datetime1->diff($datetime2);
			$sec = $interval->format('%S');
			$min = $interval->format('%I');
			$hour = $interval->format('%H');
			$time = mktime($hour, $min, $sec) % 86400;
			$arr = array('time' => $time, 'items' => $obj->select_from_db('items'));
			echo json_encode($arr);
			break;
		case 'getwinner':
			$obj = new DB_service();
			$arr = array('winners' => $obj->select_from_db('winners'));
			echo json_encode($arr);
			break;
		case 'getDate':
			$obj = new DB_service();
			print $obj->getDate();
			break;
		case 'toservice':
			$obj = new DB_service();
			$pardate = $obj->getDates();
			$datetime1 = new DateTime("now");
			if($datetime1->format('H') >= 10 && $datetime1->format('H') <= 12){
				print "today event started at 19:00!";
			}
			elseif($datetime1->format('H') >= 20 && $datetime1->format('H') <= 22){
				print "event ended, check the winners!";

			} 
			else print "null";
			break;
		case 'getversion':
			$obj = new DB_service();
			$obj->getversion();
			break;
		default:
			break;
	}

?>