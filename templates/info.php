<?php
	
	//echo 'Request is ony for info';
	
	// when getting info, should return an array like this:

	$plugins = get_posts( array( 
		'post_type'		=> 'dev_project',
		'numberposts'	=> -1,
		'metakey'		=> 'dev_project_Project_Type',
		'metavalue'		=> 'plugin'
	
	) );
	
	foreach ( $plugins as $plugin ) {
	
		$latest_plugins[$plugin->ID] = array(
			'id'					=> $plugin->ID,
			'title'					=> $plugin->post_title,
			'short_description'		=> get_post_meta( $plugin->ID , 'dev_projects_Short_Description' , true ),
			'url'					=> get_post_meta( $plugin->ID , 'dev_projects_Project_URL' , true ),
		);
	
	}
	
	/*
	$latest_plugins = array( 
            '264' => array(
                    'id' 					=> '264',
                    'title' 				=> 'WHMCS MU Provisioning',
                    'version' 				=> '1',
                    'autoupdate' 			=> '1',
                    'short_description' 	=> 'Run your own hosting company and want to expand your business? Then why not sell websites direct in your WordPress Multisite Installation. Thats right, automate your WordPress Multisite business!',
                    'url' 					=> 'http://premium.wpmudev.org/project/whmcs-multisite-provisioning/',
                ),
	);
	*/
	
	$latest_themes = array(
            '237' => array(
                    'id' 					=> '237',
                    'title' 				=> 'SimpleMarket',
                    'version' 				=> '1.1.1',
                    'autoupdate' 			=> '1',
                    'short_description' 	=> "SimpleMarket is all about simplicity. Get your website up and running in seconds with the simplest theme you'll ever setup!",
                    'url' 					=> 'http://premium.wpmudev.org/project/simplemarket/',
                ),
	);

	 $latest_release = array(
            		'id' 					=> '264',
            		'autoupdate' 			=> '1',
            		'title' 				=> 'WHMCS MU Provisioning',
            		'short_description' 	=> "Run your own hosting company and want to expand your business? Then why not sell websites direct in your WordPress Multisite Installation. Thats right, automate your WordPress Multisite business!",
            		'url' 					=> 'http://premium.wpmudev.org/project/whmcs-multisite-provisioning/',
       		 	);
	
	$membership = array(
	
			// include membership info - active, inactive, about to expire? etc...
	);
	
	$data = array(
		'latest_projects' => $latest_projects,

		'latest_plugins' => $latest_plugins,
		//'latest_themes' => $latest_themes,
		//'latest_release' => $latest_release,
		//'membership' => $membership
	);
	
	header('Status: 200');
	print(maybe_serialize($data));
	
	//print '<pre>'; print_r( $data ); print '</pre>';

?>