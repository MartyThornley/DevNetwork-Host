<?php
/*
 * General functions to be used outside of classes
 *
 */

	function get_dev_networks( $id = '' ) {

		$networks = get_posts( array(
			'post_type' => 'dev_network',
			'numberposts' => '-1',
			'orderby' => 'post_name',
			'order' => 'ASC',
			'include' => $id,
		) );
		
		foreach( $networks as $network ) {
			$available_networks[$network->ID]['title'] = $network->post_title;
			$available_networks[$network->ID]['name'] = $network->post_name;
			$available_networks[$network->ID]['access'] = get_post_meta( $network->ID , 'dev_networks_Access' , true );
		} 

		return $available_networks;
	}

	function encode_key ( $string ) {
		$string = sprintf('%1$09d', $string);
	    $key = sha1(DEV_NETWORK_KEY);
	    $strLen = strlen($string);
	    $keyLen = strlen($key);
	    for ($i = 0; $i < $strLen; $i++) {
	        $ordStr = ord(substr($string,$i,1));
	        if ($j == $keyLen) { $j = 0; }
	        $ordKey = ord(substr($key,$j,1));
	        $j++;
	        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
	    }
	    return $hash;
	}
	
	function decode_key ( $string ) {
	    $key = sha1(DEV_NETWORK_KEY);
	    $strLen = strlen($string);
	    $keyLen = strlen($key);
	    for ($i = 0; $i < $strLen; $i+=2) {
	        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
	        if ($j == $keyLen) { $j = 0; }
	        $ordKey = ord(substr($key,$j,1));
	        $j++;
	        $hash .= chr($ordStr - $ordKey);
	    }
	    return intval( $hash );
	}
?>