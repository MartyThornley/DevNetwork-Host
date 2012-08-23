<?php

	/**
	 * Admin Class
	 * 
	 * @since 1.0
	 */

if ( !class_exists( 'Plugin_Starter_Admin' ) ) {
	
	exit;
	
} else {	
	
	class Dev_Network_Admin extends Plugin_Starter_Admin {

		public function __construct() {
		
			parent::__construct();
		
			require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'classes/class_Dev_Projects_Tabbed_Meta_Box.php' );
			require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'classes/class_Dev_Networks_Tabbed_Meta_Box.php' );

		}

		/**
		 * Run during plugin setup
		 *
		 */
		function definitions() {
		
			parent::definitions();

			$this->debug 			= false;	

			$this->domain 			= 'dev_network';
			$this->plugin_path 		= DEV_NETWORK_API_PATH;
			$this->plugin_url 		= DEV_NETWORK_API_URL;

		}
		
		/**
		 * Run during admin init
		 *
		 */
		function admin_init() {

			parent::admin_init();
			
			if ( class_exists( 'Dev_Projects_Tabbed_Meta_Box' ) )
				new Dev_Projects_Tabbed_Meta_Box( 'dev_project' );
	
			if ( class_exists( 'Dev_Networks_Tabbed_Meta_Box' ) )
				new Dev_Networks_Tabbed_Meta_Box( 'dev_network' );

		}		
	
	}
	
}