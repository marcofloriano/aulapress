<?php
// Primary plugin class
// Fully qualified class name: /src/Post(Subnamespace)/Edit.php(Class file)

// Print the path of the current directory
// echo plugin_dir_path(__FILE__);

// Load a file from subfolder
// include plugin_dir_path(__FILE__) . 'src/Aulapress.php';

// Store plugin's root path as a variable (constant) for later use
// define ( 'AULAPRESS_DIR', plugin_dir_path(  __FILE__ ) );

// Print URL of current file/folder
// echo plugin_dir_url(__FILE__);

// WordPress Coding Standards
// https://developer.wordpress.org/coding-standards/wordpress-coding-standards/

//Aulapress Main Menu
add_action( 'admin_menu', 'aulapress_create_menu' );

function aulapress_create_menu() {

	//creates aulapress custom top-level menu
	add_menu_page( 'Aulapress Options', 'Aulapress',
		'manage_options', 'aulapress-options', 'aulapress_settings_page',
		'dashicons-welcome-learn-more', 30 );

	//creates aulapress submenu items
	add_submenu_page( 'aulapress-options', 'Aulapress Settings', 'Settings',
		'manage_options', 'aulapress-options', 'aulapress_settings_page' );
	add_submenu_page( 'aulapress-options', 'About Aulapress', 'About',
		'manage_options', 'aulapress-about', 'aulapress_about_page' );
	add_submenu_page( 'aulapress-options', 'Help And Support', 'Help',
		'manage_options', 'aulapress-help', 'aulapress_help_page' );	
	add_submenu_page( 'aulapress-options', 'Uninstall Aulapress', 'Uninstall',
		'manage_options', 'aulapress-uninstall', 'aulapress_uninstall_page' );
}

//Aulapress Settings Page
//Options array to store on wordpress database options table
$aulapress_options = array(
	'color'    => 'red',
	'fontsize' => '120%',
	'border'   => '2px solid red'
);
//creates new and does nothing if the option name already exists
add_option( 'aulapress_plugin_options',  $aulapress_options );

$aulapress_new_options = array(
	'color'    => 'green',
	'fontsize' => '100%',
	'border'   => '1px solid black'
);
//checks if the option already exists before updating its value and creates it if needed
update_option( 'aulapress_plugin_options', $aulapress_new_options );

//fetch our array of options
$aulapress_options = get_option( 'aulapress_plugin_options' );

//store individual option values in variables
$color = $aulapress_options[ 'color' ];
$fontsize = $aulapress_options[ 'fontsize' ];
$border = $aulapress_options[ 'border' ];