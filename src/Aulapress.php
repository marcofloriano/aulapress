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
}

// Aulapress Settings Page
function aulapress_settings_page() {
	// Fetch our array of frontend options
	// $aulapress_options = get_option( 'aulapress_plugin_options' );

	// Store individual option values in variables
	// $color    = $aulapress_options[ 'color' ];
	// $fontsize = $aulapress_options[ 'fontsize' ];
	// $border   = $aulapress_options[ 'border' ];

?>
	<div class="wrap">
		<h2>My Plugin</h2>
		<form action="options.php" method="post">			
		</form>
	</div>
<?php
	// Register plugin settings
	$args = array(
		'type'              => 'string',
		'sanitize_callback' => 'aulapress_validate_options',
		'default'           => NULL
	);
	register_setting( 'aulapress_plugin_options', 'aulapress_plugin_options', $args );

	add_settings_section(
		'aulapress_plugin_main',
		'Aulapress Plugin Settings',
		'aulapress_plugin_section_text',
		'aulapress_plugin'
	);

	add_settings_field(
		'aulapress_plugin_name',
		'Your Name',
		'aulapress_plugin_setting_name',
		'aulapress_plugin',
		'aulapress_plugin_main'
	);
}

// Draw the section header
function aulapress_plugin_section_text() {
	echo '<p>Enter your settings here</p>';
}

// Display and fill the Name form field
function aulapress_plugin_setting_name() {

	// get option 'text_string' value from the database
	$options = get_option( 'aulapress_plugin_options' );
	$name = $options['name'];

	// echo the field
	?>
	<input id="name" type="text" name="aulapress_plugin_options[name]" value="<?php esc_attr( $name ); ?>" >
<?php
}

// Aulapress About Page
function aulapress_about_page() {
?>
	<div class="wrap">
		<h2>About Aulapress</h2>
	</div>
<?php
}
