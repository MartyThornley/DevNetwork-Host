<?php

/**
 * Base class for Dev Network APIKEYS.
 *
 * @package DevNetwork
 *
 */

/*********************** TODO ******************************************************



*********************** END TODO ******************************************************/

class Dev_Network_APIKEY {

	var $key;
	
	function __construct( $key = '' ){
	
		$this->current_user = wp_get_current_user();
	}

}

?>