<?php 
/*
Plugin Name: WP Developer Network API
Plugin URI: http://pluginstarter.com
Description: Host your own API for a network of plugins, themes, etc.
Author: Marty Thornley
Version: .1
Author URI: http://pluginstarter.com/
Network: true

*/

	// define a random strng for your key
	$key = '986ftyfuytfyt976f7f';
	
	// could move this into class at some point...
	if ( !defined( 'DEV_NETWORK_KEY' ) )				define( 'DEV_NETWORK_KEY',				$key );
	if ( !defined( 'DEV_NETWORK_API_DEBUG' ) )			define( 'DEV_NETWORK_API_DEBUG',		false );
	if ( !defined( 'DEV_NETWORK_API_PATH' ) )			define( 'DEV_NETWORK_API_PATH',			plugin_dir_path( __FILE__ ) );
	if ( !defined( 'DEV_NETWORK_API_URL' ) )			define( 'DEV_NETWORK_API_URL',			plugin_dir_url( __FILE__ ) );

	if ( !class_exists( 'Plugin_Starter' ) )		
		require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'includes/plugin-starter.php' );		

	require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'functions/functions.php' );
	
	require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'classes/class_Dev_Network_API.php' );
	require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'classes/class_Dev_Network_User.php' );
	require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'classes/class_Dev_Network_APIKEY.php' );

	$Dev_Network_API = new Dev_Network_API;
?>