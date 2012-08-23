<?php

/**
 * Networks Meta box class
 */

if ( !class_exists( 'Tabbed_Meta_Box' ) ) {
	
	exit;
	
} else {	

	class Dev_Networks_Tabbed_Meta_Box extends Tabbed_Meta_Box {
		
		var $post_type;
		var $domain;
		var $plugin_path;
		var $plugin_url;
		
		function __construct ( $post_type = '' ) {
			
			parent::__construct();
	
		}
				
		/**
		 * Defines the sections for metabox tabs
		 */
		function define_sections() {
		
			$this->post_type	= 'dev_network';
			$this->domain 		= 'dev_network';
			$this->plugin_path 	= DEV_NETWORK_API_PATH;
			$this->plugin_url 	= DEV_NETWORK_API_URL;
		
			$sections = array (
				'general'		=> __( 'General', $this->domain ),
				'permissions'	=> __( 'Permissions', $this->domain ),
			);
			
			$this->sections = $sections;
		}
	
	
		/**
		 * Creates a meta box on the experiments editing screen for allowing the easy input of 
		 * commonly-used post metadata.
		 *
		 * @uses add_meta_box() Adds a meta box to the post editing screen.
		 */
		function add_meta_box() {
			
			add_meta_box( $this->domain . '-meta-box', __( 'Network Settings', $this->domain ), array( $this, 'meta_box' ), $this->post_type, 'normal', 'high' );
				
		}
		
		
		/**
		 * Loads the required stylesheets for displaying the edit and post-new page in the WordPress admin.
		 *
		 */
		function enqueue_scripts() {
			global $pagenow;
			
			if ( $pagenow == ( 'post.php' || 'post-new.php' ) && $this->post_type == get_post_type() ) { 
				wp_enqueue_script( 'jquery-ui-tabs' );
			}
		}
		
		/**
		 * Creates the settings for the post meta box.  
		 *
		 * @param string $type The post type of the current post in the post editor.
		 * @param object $object - the $post object passed from the metabox so we know what post we are in
		 *
		 */
		function meta_box_args( $type = '' , $object = NULL ) {
			
			$meta = array();
				
			$prefix = 'dev_networks_';
			
			// General tab
			
			$meta['Info'] = array( 
				'name' => $prefix . 'Network_Information', 
				'title' => __( 'Network Information', $this->domain ), 
				'type' => 'paragraph', 
				'description' => __( 'Network ID: ', $this->domain ) . $object->ID,
				'tab' => 'general' 
			);	
					
			$meta['Short_Description'] = array( 
				'name' => $prefix . 'Short_Description', 
				'title' => __( 'Short Description:', $this->domain ), 
				'type' => 'textarea', 
				'description' => __( 'This is the decription that will show in the user dashboard.', $this->domain ),
				'tab' => 'general' 
			);
			
			$meta['Support_URL'] = array( 
				'name' => $prefix . 'Support_URL', 
				'title' => __( 'Support URL:', $this->domain ), 
				'type' => 'text', 
				'description' => __( 'Full URL to the support site for this network.', $this->domain ),
				'tab' => 'general' 
			);

			$meta['Site_URL'] = array( 
				'name' => $prefix . 'Site_URL', 
				'title' => __( 'Website URL:', $this->domain ), 
				'type' => 'text', 
				'description' => __( 'Full URL to the home page for this network.', $this->domain ),
				'tab' => 'general' 
			);

			// General tab
			
			$roles = get_editable_roles();
			foreach ( $roles as $role => $caps )
				$levels[ucfirst( $role )] = $role;
			
			$meta['Permissions'] = array( 
				'name' => $prefix . 'Permissions', 
				'title' => __( 'Project Permissions', $this->domain ), 
				'type' => 'paragraph', 
				'description' => __( 'Who can access projects in this network?', $this->domain ),
				'tab' => 'permissions' 
			);	

			$access_levels = array( 
				'Anyone can access' 								=> 'anyone', 
				'Choose a user level for all projects' 				=> 'user', 
				'Allow each project to choose user level' 			=> 'user_by_project', 
				//'Give access with purchase, project by project' 	=> 'product_purchase', 
				//'Use your own custom hooks to give access' 			=> 'custom_hooks' 
			);

			$meta['Access'] = array( 
				'name' => $prefix . 'Access', 
				'title' => __( 'Choose:', $this->domain ), 
				'type' => 'radio',
				'use_key_and_value' => true,
				'options' => $access_levels,
				'default' => 'author', 
				'description' => __( 'Choose the overall method to allow access to projects in this network.', $this->domain ),
				'tab' => 'permissions' 
			);
					
			$meta['User_Roles'] = array( 
				'name' => $prefix . 'User_Roles', 
				'title' => __( 'User Roles:', $this->domain ), 
				'type' => 'radio',
				'use_key_and_value' => true,
				'options' => $levels,
				'default' => 'author', 
				'description' => __( 'Choose the level of user who can access this project.', $this->domain ),
				'tab' => 'permissions' 
			);
					
			return $meta;
		}
	
	} // end class 
}