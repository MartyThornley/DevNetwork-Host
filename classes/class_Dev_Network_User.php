<?php

/**
 * Base class for Dev Network User.
 *
 * @package DevNetwork
 *
 */

/*********************** TODO ******************************************************

	// 	define thier access - ( project, entire blog, entire multisite network, membership level )

	// 	add hooks so any membership / eccommerce plugin can give them access to any of those

	//	

*********************** END TODO ******************************************************/

// testing some user capabilities


		
		/*
			// example user_access meta
		
			$user_access = array(
				'projects' 	=> array( 'all' => 1 , '32' => 1 , '6' => 1 ),
				'sites' 	=> array( 'all' => 1 , '32' => 1 , '6' => 1 ),
				'posts' 	=> array( 'all' => 1 , '32' => 1 , '6' => 1 ),
				'urls' 		=> array( 'all' => 1 , '32' => 1 , '6' => 1 , 'http://mysites.com' => 0 ),
			);
		*/
		
		// we are setting a single access with a value...

class Dev_Network_User {

	var $current_user;
	var $ID;
	var $blog_id;
	var $userdata;
	
	function __construct( $ID=0 , $api_key = false ) {
		
		$this->ID = $ID;
				
		if ( $api_key ) { 

			$args  = array(  
			  	'fields' 		=> 'all',
				'meta_key'		=> 'dev_api_key',
				'meta_value'	=> $this->ID,
			); 
			
			$user = get_users( $args );
			if ( isset( $user[0]->ID ) )
				$this->ID = $user[0]->ID;
		} 
		
		$this->definitions();
	}

	function definitions() {
	
		$this->userdata = get_userdata( $this->ID );

	}
	
	function give_user_access( $access_type , $value=NULL ){
		$user_access = get_user_meta( $this->ID , 'dev_user_access' , true );
		
		if ( $value ) {
			$user_access[$access_type][$value] = 1;
			update_user_meta( $this->ID , 'dev_user_access' , $user_access );			
		}
			
	}

	function create_apikey(){
		
		$key = encode_key( $this->ID );
				
		update_user_meta( $this->ID , 'dev_api_key' , $key );
	
		if ( $key = get_user_meta( $this->ID , 'dev_api_key' , true ) )
			return $key;

	}

	function delete_apikey(){
		
		if ( delete_user_meta( $this->ID , 'dev_api_key' ) )		
			return true;
		else
			return false;
	}
	
	function is_apikey_valid(){
		
		$key = get_user_meta( $this->ID , 'dev_api_key' , true );
		
		if ( $key == encode_key( $this->ID ) ) {			
			return true;
		} else {
			$this->delete_apikey();
			return false;
		}
	}
	
	function get_user_access( $access_type , $value=NULL ){
		
		$user_access = get_user_meta( $this->ID , 'dev_user_access' , true );
		
		if ( $value ) {
			if ( isset( $user_access[$access_type][$value] ) )
				$return = true;
			else
				$return = false;
		} else {
				$return = false;
		}
		
		return $return;

	}

	/*
	 * Remove user access
	 */	
	function revoke_user_access( $access_type , $value=NULL ){
		
		$user_access = get_user_meta( $this->ID , 'dev_user_access' , true );
		
		if ( $value && isset( $user_access[$access_type][$value] ) ) {
			unset( $user_access[$access_type][$value] );
			update_user_meta( $this->ID , 'dev_user_access' , $user_access );			
		}
	}	
	
	/*
	 * Conditional - can a user access something?
	 *
	 * @return boolean
	 */
	function user_can_access( $access_type , $value=NULL ){
		
		$user_access = get_user_meta( $this->ID , 'dev_user_access' , true );
		
		if ( $value ) {
			if ( ( isset( $user_access[$access_type]['all'] ) && $user_access[$access_type]['all'] == 1 ) || $user_access[$access_type][$value] )
				$return = true;
			else
				$return = false;
		} else {
				$return = false;
		}
		
		return $return;		
		
	}	

}
?>