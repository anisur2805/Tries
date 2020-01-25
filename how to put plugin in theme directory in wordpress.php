<?php



################

##### Goto http://tgmpluginactivation.com site and download TGM plugin
##### Put class-tgm-plugin-activation.php file in theme directory
##### Open functions.php file and link tgm class file ( require_once )
##### Also put this below code in functions.php file
##### there are two ways to put plugin in theme directory ( inside theme folder, see below example )
##### And you are done


################
/*
 * Include TGM Class File
 */
require_once get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'art_tgmpa_register');
function art_tgmpa_register() {
	$plugins = array(
		array(
			'name'		=> 'AR Back To Top',
			'slug'		=> 'arbtt2',
			'required'	=> false,
			//'source'             => 'http://files.my-website.com/my-awesome-plugin.zip', // The "internal" source of the plugin.
			'source'             => get_stylesheet_directory() . '/inc/plugins/ar-back-to-top.zip',
	    ),
	    
	    // This is an example of how to include a plugin from the WordPress Plugin Repository.
		array(
			'name'      => 'Wordpress Seo by Yoast', // plugin will download from wp plugin repository
			'slug'      => 'wordpress-seo',
			'required'  => false,
		),
	);
	$config = array(
		'id'           => 'tgmpa',
	    // 'default_path' => get_stylesheet_directory() . '/inc/plugins/', // default absolute path
	    'menu'         => 'tgmpa-install-plugins', // menu slug
	    'capability'   => 'edit_theme_options',
	    'has_notices'  => true,
	    'dismissable'  => true,
	    'dismiss_msg'  => 'I really, really need you to install these plugins, okay?',
	    'is_automatic' => false,
	    'message'      => '<!--Hey there.-->',
	    'strings'      => array()
	);

	tgmpa( $plugins, $config );

}