<?php

	global $wp_query; 
	$query_vars = $wp_query->query_vars;
	
	// setup data to return
	$data = array();
	
	/* 
	 * testing info
	 */	

	//include( trailingslashit( DEV_NETWORK_API_PATH ) . 'templates/testing.php' );
	
	/* 
	 * Just looking for info on latest updates
	 *
	 * no api_key needed
	 */	
	if ( isset( $query_vars['api_info'] ) ) {
		
		include( trailingslashit( DEV_NETWORK_API_PATH ) . 'templates/info.php' );
	
	/* 
	 * empty api_key
	 */	
	} elseif ( !isset( $query_vars['api_key'] ) ) {
			
		echo 'API Key is missing!'; 		
		
		// need to return 404 if missing
		// header('Status: 404');
	
	/* 
	 * api_key sent
	 */
	} else {
	
		$Dev_Network_User = new Dev_Network_User(  $query_vars['api_key']  , true );

		// API KEY is valid
		if ( $Dev_Network_User->is_apikey_valid() ) {
			
			$debug_msg .= 'API Key is valid!<br /><br />';

			// is this a dev project?		
			if ( isset( $query_vars['api_project'] ) && get_post_type( $query_vars['api_project'] ) == 'dev_project' ) {
				
				$debug_msg .= 'This is a dev project!<br /><br />';
	
				// can user access project?	
				if ( $Dev_Network_User->user_can_access( 'projects' , $query_vars['api_project'] ) ) {
				
					$debug_msg .= 'User can access project!<br /><br />';
				
					// what are they trying to do?
					if ( isset( $query_vars['api_action'] ) ) {
				
						$debug_msg .= 'User is trying to '.$query_vars['api_action'].'<br /><br />';
						
						switch ( $query_vars['api_action'] ) {
							
							case 'download' :
									
									$data[] = array(
									
										'stuff' => 'things',
									
									);
									
								break;
								
							case 'check_version' :
							
								break;
							
							default :
							
								break;
						
						}	
					
					} else {
					
						$debug_msg .= 'User has not requested anything.<br /><br />';	
					
					}
					
				} else {
					
					$debug_msg .= 'User can NOT access!<br /><br />';
				
				}
				
			// this is not a dev project or no id sent	
			} else {
				
				$debug_msg .= ( !isset( $query_vars['api_project'] ) ? 'No Project ID sent' : 'This is not a dev project!' );

			}
			
		// API Key not valid
		} else {
			
			$debug_msg .= 'API Key is not valid!<br /><br />';
		
		}

	}
	
	
	
	// provide json encoded return
	if ( !empty( $data ) ) {
	
		//header( 'Status: 200' );
		print( json_encode( $data ) );
	
	
	} else {

		echo $debug_msg;

	}
	
?>