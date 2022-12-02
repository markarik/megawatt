<?php

$allowed_actions = ['topup', 'expiries', 'client_broadcasts', 'agent_broadcasts'];
$action = $argv[1];

if( $action && in_array($action, $allowed_actions) ){
	try{
		$url = 'http://system.megawatt.co.ke/crons/' . $action;
		// $cron_res = file_get_contents($url);
		// print_r($cron_res);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);
		
		echo 'Processed successfully';
		print_r($output);
		echo '  ===>>  ';
		print_r($error);
		echo '  ===>>  ';
	}catch(Exception $e){
		print_r($e);
		echo $e>getMessage();
	}
}else{
	if( !$action ){
		echo 'No action provided';
	}elseif( !in_array($action, $allowed_actions) ){
		echo 'Not an allowed action';
	}
}

?>
