<?php

/**
 * Meta box class
 */

if ( !class_exists( 'Tabbed_Meta_Box' ) ) {
	
	exit;
	
} else {	

	class Dev_Projects_Tabbed_Meta_Box extends Tabbed_Meta_Box {
		
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
		
			$this->post_type	= 'dev_project';
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
			
			add_meta_box( $this->domain . '-meta-box', __( 'Project Attributes', $this->domain ), array( $this, 'meta_box' ), $this->post_type, 'normal', 'high' );
				
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
			
			global $Dev_Network_API;
			
			$meta = array();
				
			$prefix = 'dev_projects_';

			// General tab
					
			$meta['Info'] = array( 
				'name' => $prefix . 'Project_Information', 
				'title' => __( 'Project Information', $this->domain ), 
				'type' => 'paragraph', 
				'description' => __( 'Project ID: ', $this->domain ) . $object->ID,
				'tab' => 'general' 
			);	



			$meta['Project_Type'] = array( 
				'name' => $prefix . 'Project_Type', 
				'title' => __( 'What type of project is this?', $this->domain ), 
				'type' => 'select',
				'use_key_and_value' => true,
				'options' => $Dev_Network_API->project_types, 
				'tab' => 'general' 
			);	

			$meta['Latest_Version'] = array( 
				'name' => $prefix . 'Latest_Version', 
				'title' => __( 'Latest Version:', $this->domain ), 
				'type' => 'text', 
				'description' => __( 'The current version.', $this->domain ),
				'tab' => 'general' 
			);
					
			$meta['Short_Description'] = array( 
				'name' => $prefix . 'Short_Description', 
				'title' => __( 'Short Description:', $this->domain ), 
				'type' => 'textarea', 
				'description' => __( 'This is the decription that will show in the user dashboard.', $this->domain ),
				'tab' => 'general' 
			);
			
			$meta['Project_URL'] = array( 
				'name' => $prefix . 'Project_URL', 
				'title' => __( 'Project URL:', $this->domain ), 
				'type' => 'text', 
				'description' => __( 'Full URL to the project.', $this->domain ),
				'tab' => 'general' 
			);

			$meta['Download_URL'] = array( 
				'name' => $prefix . 'Download_URL', 
				'title' => __( 'Download URL:', $this->domain ), 
				'type' => 'text', 
				'description' => __( 'Full URL to the most recent (.zip) version of the project.', $this->domain ),
				'tab' => 'general' 
			);

			// Permissions tab
			
			$networks = get_dev_networks();
			
			$available_networks['No Network'] = '0';
			
			foreach( $networks as $id => $info ) {
				
				$available_networks[$info['title']] = $id;
			
			}
								
			$meta['Dev_Network_Intro'] = array( 
				'name' => $prefix . 'Dev_Network_Intro', 
				'title' => __( 'Assign to network', $this->domain ), 
				'type' => 'paragraph', 
				'tab' => 'permissions' 
			);	
			
			$meta['Dev_Network'] = array( 
				'name' => $prefix . 'Dev_Network', 
				'title' => __( 'Assign this project to a network:', $this->domain ), 
				'type' => 'select',
				'use_key_and_value' => true,
				'options' => $available_networks, 
				'tab' => 'permissions' 
			);	
			
			$roles = get_editable_roles();
			foreach ( $roles as $role => $caps )
				$levels[ucfirst( $role )] = $role;
			
			$meta['Permissions'] = array( 
				'name' => $prefix . 'Permissions', 
				'title' => __( 'Project Permissions', $this->domain ), 
				'type' => 'paragraph', 
				'description' => __( 'Who can access this project?', $this->domain ),
				'tab' => 'permissions' 
			);	
			
			$access_options = array( 
				'Anyone' 						=> 'anyone' , 
				'Limit by user level' 			=> 'user' , 
				//'Give access with purchase' 	=> 'purchase'
			);
					
			$meta['Access'] = array( 
				'name' => $prefix . 'Access', 
				'title' => __( 'Can anyone access this project or do you want to limit access to a user level?', $this->domain ), 
				//'description' => __( 'Choose the overall method to access this project.', $this->domain ),

				'type' => 'radio',
				'use_key_and_value' => true,
				'options' => $access_options,
				'default' => 'anyone', 
				'tab' => 'permissions' 
			);
			
			$meta['User_Roles'] = array( 
				'name' => $prefix . 'User_Roles', 
				'title' => __( 'Choose the level of user who can access this project:', $this->domain ), 
				//'description' => __( 'Choose the level of user who can access this project.', $this->domain ),
				'type' => 'radio',
				'options' => $levels,
				'use_key_and_value' => true,
				'default' => 'author', 
				'tab' => 'permissions' 
			);
					
			return $meta;
		}
	
	} // end class 
}