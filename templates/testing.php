<?php

	// api_key 		=> $query_vars['api_key']
	// api_action 	=> $query_vars['api_action']
	// api_project 	=> $query_vars['api_project']
 
	/***********************
	
			TESTING
	
	***********************/

  	//to check against registered urls...
	//print_r( parse_url( $_SERVER['HTTP_REFERER'] ) );	
	
 	$test_key = encode_key( '2'  );
	echo 'API_KEY for user_id 2 '.$test_key.'<br />';
	//update_user_meta( '2' , 'dev_api_key' , $test_key );			
	//delete_user_meta( '2' , 'dev_api_key' );	

 	$api_info = array(
		'api_info' 		=> $query_vars['api_info'],
		'api_key' 		=> $query_vars['api_key'],
		'api_project' 	=> $query_vars['api_project'],
		'api_action' 	=> $query_vars['api_action'],
	);
	
	// print '<pre>'; print_r( $api_info ); print '</pre>';
		
	/***********************
	
			END TESTING
	
	***********************/

?>