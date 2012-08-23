<?php

/**
 * Base class for Dev Netowrk API.
 *
 * @package DevNetwork
 *
 */

/*********************** TODO ******************************************************

// generate API keys - hash of username and ????

// post type for dev project info
// drop down meta box to choose project type: plugin, theme, mu-plugin

// add custom post types for updates

// long-term - pay to download? maybe integrate with easy digital downloads?

*********************** END TODO ******************************************************/


class Dev_Network_API extends Plugin_Starter {

	var $debug =		false;	
	var $rewrite_slug;	
	/*
	 * Construct 
	 */
	function __construct() {	 
		
		parent::__construct();

		/* Load Admin */
		if ( is_admin() ) {
			require_once( trailingslashit( DEV_NETWORK_API_PATH ) . 'classes/class_Dev_Network_Admin.php' );
			$Dev_Network_Admin = &new Dev_Network_Admin();	
		}

	}

	/**
	 * Loading the gettext textdomain first from the WP languages directory,
	 * and if that fails try the subfolder /languages/ in the plugin directory.
	 * @return void
	 */
	function localize() {
		load_plugin_textdomain( 'dev-network' , false , DEV_NETWORK_API_PATH . '/languages/' );
	}

	/*
	 * Define 
	 */	
	function definitions() {
		
		$this->blog_url 			= get_option('home');
		$this->rewrite_slug			= 'api';
		$this->domain				= 'dev_network';
		
		$this->basename				= 'dev_network';
		$this->plugin_path			= DEV_NETWORK_API_PATH;
		$this->plugin_url			= DEV_NETWORK_API_URL;

		$this->project_types		= array( 
										'Plugin' 	=> 'plugin', 
										'Theme'		=> 'theme',
									);
		
	}
	
	/*
	 * Init 
	 */
	function init() {
		$this->register_post_types();
	}
	
	/**
	 * Flush Rules
	 */
	function flush_rules() {
		
		$rules = get_option( 'rewrite_rules' );
				
		$myrules = array (
			$this->rewrite_slug.'/info/?$',
			$this->rewrite_slug.'/([A-Za-z0-9]{1,})/?$',
			$this->rewrite_slug.'/([A-Za-z0-9]{1,})/([0-9]{1,})/?$',
			$this->rewrite_slug.'/([A-Za-z0-9]{1,})/([0-9]{1,})/([A-Za-z0-9]{1,})/?$',
		);
		
		$need_to_flush = false;
		
		foreach ( $myrules as $rule ) {
			if ( !isset( $rules[$rule] ) ) {
				$need_to_flush = true;
			}
		}
		
		if ( $need_to_flush ) {
			global $wp_rewrite;
		   	$wp_rewrite->flush_rules();
		}	
		// for testing only
		//global $wp_rewrite;
		//$wp_rewrite->flush_rules();	
	}

	/**
	 * Add rewrite rules
	 */
	function insert_rewrite_rules( $rules ) {
				
		$newrules = array();
		
		// API calls...
		$newrules[$this->rewrite_slug.'/info/?$']														= 'index.php?api_info=true';

		$newrules[$this->rewrite_slug.'/([A-Za-z0-9]{1,})/?$']										= 'index.php?api_key=$matches[1]';
		$newrules[$this->rewrite_slug.'/([A-Za-z0-9]{1,})/([0-9]{1,})/?$']							= 'index.php?api_key=$matches[1]&api_project=$matches[2]';
		$newrules[$this->rewrite_slug.'/([A-Za-z0-9]{1,})/([0-9]{1,})/([A-Za-z0-9]{1,})/?$']		= 'index.php?api_key=$matches[1]&api_project=$matches[2]&api_action=$matches[3]';

		return $newrules + $rules;	
	}
	
	/**
	 * Add Query vars
	 */
	function insert_query_vars( $vars ) {
	    array_push( $vars, 'api_info' );
	    array_push( $vars, 'api_key' );
	    array_push( $vars, 'api_action' );
	    array_push( $vars, 'api_project' );

		return $vars;
	}	

	/**
	 * Add Query vars
	 */
	function template_redirect() {

		global $wp_query; 
		$query_vars = $wp_query->query_vars;
		
		if ( is_archive() )  {
			
			// skip in case we have categories or posts named 'api'
			
		} elseif ( isset( $query_vars['api_key'] ) || strpos( $_SERVER['REQUEST_URI'], '/api' ) ) {
			include trailingslashit( DEV_NETWORK_API_PATH ) . 'templates/api.php'; 	
			exit;
		}
	
	}
	
	/*
	 * Register Post Types 
	 */	
	function register_post_types() {

		// dev networks
		
		$network_labels = array ( 
			'menu_name'				=> __( 'Dev Networks', 'dev_network' ),
			'name' 					=> _x( 'Dev Networks', 'post type general name' ),
			'singular_name' 		=> _x( 'Dev Network', 'post type singular name' ),
			'add_new' 				=> _x( 'Add New', 'Dev Network'),
			'add_new_item'			=> __( 'Add New' ),
			'edit_item' 			=> __( 'Edit Dev Network' ),
			'new_item' 				=> __( 'New Dev Network' ),
			'view_item' 			=> __( 'View Dev Network' ),
			'search_items' 			=> __( 'Search Dev Networks' ),
			'not_found' 			=> __( 'No Dev Networks found' ),
			'not_found_in_trash' 	=> __( 'No Dev Networks found in the trash' ),
		);
		
		$dev_network_args = array (
			'labels' 				=> $network_labels,
			'has_archive'			=> false,
			'public' 				=> false,
			'show_ui' 				=> true,
			'publicly_queryable'	=> false,
			'exclude_from_search'	=> true,
			'hierarchical' 			=> true,
			'revisions'				=> false,
			'capability_type' 		=> 'page',
			'query_var'				=> 'dev_network',
			'rewrite' 				=> array( 'slug' => 'dev_network' , 'with_front' => false ),
			
			'supports'				=> array( 'title', 'custom-fields', 'thumbnail', 'page-attributes' )
		);		
		
		register_post_type( 'dev_network', $dev_network_args );
		
		// dev projects
		$project_labels = array ( 
			'menu_name'				=> __( 'Dev Projects', 'seo_gallery' ),
			'name' 					=> _x( 'Dev Projects', 'post type general name' ),
			'singular_name' 		=> _x( 'Dev Project', 'post type singular name' ),
			'add_new' 				=> _x( 'Add New', 'Dev Project'),
			'add_new_item'			=> __( 'Add New' ),
			'edit_item' 			=> __( 'Edit Dev Project' ),
			'new_item' 				=> __( 'New Dev Project' ),
			'view_item' 			=> __( 'View Dev Project' ),
			'search_items' 			=> __( 'Search Dev Projects' ),
			'not_found' 			=> __( 'No Dev Projects found' ),
			'not_found_in_trash' 	=> __( 'No Dev Projects found in the trash' ),
		);
		
		$dev_project_args = array (
			'labels' 				=> $project_labels,
			'has_archive'			=> false,
			'public' 				=> false,
			'show_ui' 				=> true,
			'publicly_queryable'	=> false,
			'exclude_from_search'	=> true,
			'hierarchical' 			=> true,
			'revisions'				=> false,
			'capability_type' 		=> 'page',
			'query_var'				=> 'dev_project',
			'rewrite' 				=> array( 'slug' => 'dev_project' , 'with_front' => false ),
			
			'supports'				=> array( 'title', 'custom-fields', 'thumbnail', 'page-attributes' )
		);		
		
		register_post_type( 'dev_project', $dev_project_args );
		

		
		// dev updates
	}
}
?>