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
		<h2><span class="dashicons dashicons-admin-generic"></span> Settings</h2>
		<?php settings_errors(); ?>
		<form action="options.php" method="post">
		<?php
		// References the whitelisted option you have declared with register_setting()
		settings_fields( 'aulapress_plugin_options' );
		// Outputs all the sections and form fields previously defined
		do_settings_sections( 'aulapress_plugin' );
		// Display the form submit buton as an alternative to the bellow input practice
		// submit_button( 'Save Changes', 'primary' );
		?>
		<br>
		<input type="submit" name="Save" value="Save Options" class="button-primary">
		<a href="<?php admin_url(sprintf(basename($_SERVER['REQUEST_URI']))); ?>" class="button-secondary">Cancel</a>
		</form>
	</div>
	<?php
}

// Register plugin settings
add_action( 'admin_init', 'aulapress_admin_init' );

function aulapress_admin_init() {
	$args = array(
		'type'              => 'string',
		'sanitize_callback' => 'aulapress_validate_options',
		'default'           => NULL
	);

	// Register our settings
	register_setting( 'aulapress_plugin_options', 'aulapress_plugin_options', $args );

	// Add a settings section
	add_settings_section(
		'aulapress_main',
		'Aulapress Options and Configuration',
		'aulapress_section_text',
		'aulapress_plugin'
	);

	// Create our setting field for name
	add_settings_field(
		'aulapress_plugin_name',
		'Your Name',
		'aulapress_setting_name',
		'aulapress_plugin',
		'aulapress_main'
	);

	// Create our settings field for favorite holiday
	add_settings_field(
		'aulapress_plugin_fav_holiday',
		'Favorite Holiday',
		'aulapress_setting_fav_holiday',
		'aulapress_plugin',
		'aulapress_main'
	);

	// Create our setting field for beast mode
	add_settings_field(
		'aulapress_plugin_beast_mode',
		'Enable Beast Mode?',
		'aulapress_setting_beast_mode',
		'aulapress_plugin',
		'aulapress_main'
	);
}

// Draw the section header
function aulapress_section_text() {
	echo '<p>Select the desired options to render aulapress courses pages</p>';
}

// Display and fill the Name form field
function aulapress_setting_name() {

	// get option 'text_string' value from the database
	$options = get_option( 'aulapress_plugin_options', [ 'name' => '' ] );
	$name = $options['name'];
	// echo the field
	echo "<input id='name' name='aulapress_plugin_options[name]' type='text' value='" . esc_attr( $name ) . "' />";
}

// Display and select field
function aulapress_setting_fav_holiday() {

	// Get option 'fav holiday' value from the database
	// Set to Christmas as default if the option does not exist
	$options = get_option( 'aulapress_plugin_options', [ 'fav_holiday' => 'Christmas' ] );
	$fav_holiday = $options['fav_holiday'];

	// Define the select option values for favorite holiday
	$items = array( 'Christmas', 'Easter', 'Pentecost' );

	echo "<select id='fav_holiday' name='aulapress_plugin_options[fav_holiday]' >";

	foreach ( $items as $item ) {
		// Loop through the option values
		// If saved option matches the option value, select it
		echo "<option value='" . $item . "' "
		// WordPress core function which compares two values and, if they match return selected="selected"
		. selected( $fav_holiday, $item, false ) . ">" . esc_html( $item )
		. "</option>";
	}

	echo "</selected>";
}

// Display and set radio button fields
function aulapress_setting_beast_mode() {

	// Get option 'beast_mode' value from the database
	// Set to 'disabled' as a default if the option does not exist
	$options = get_option( 'aulapress_plugin_options', [ 'beast_mode' => 'Disabled' ] );
	$beast_mode = $options['beast_mode'];

	// Define the radio button options
	$items = array( 'Enabled', 'Disabled' );

	foreach ($items as $item) {
		
		// Loop through the two radio button options and select if set in the option value
		// checked() is an WordPress core function to compare the saved value against the display value and, if same, output checked="checked"
		echo "<label><input " . checked( $beast_mode , $item, false ) . "
		value= '" . esc_attr( $item )  . "' name='aulapress_plugin_options[beast_mode]'
		type='radio'/>" . esc_html( $item ) . "</label><br/>";
	}
}

// Validate user input
function aulapress_validate_options( $input ) {

	// letters and spaces only for the name
	$valid['name'] = preg_replace( 
		'/[^a-zA-Z\s]/', 
		'', 
		$input['name'] 
	);

	if( $valid['name'] !== $input['name'] ) {

		add_settings_error(
			'aulapress_plugin_text_string', // undefined, probably wrong
			'aulapress_plugin_texterror',
			'Incorrect value entered! Please only input letters and spaces.',
			'error'
		);
	}

	// Sanitize the data we are receiving
	$valid['fav_holiday'] = sanitize_text_field( $input['fav_holiday'] );
	$valid['beast_mode'] = sanitize_text_field( $input['beast_mode'] );
	return $valid;
}

// Aulapress About Page
function aulapress_about_page() {
?>
	<!-- This class "wrap" sets the stage for all admin styles -->
	<div class="wrap">
		<h1><span class="dashicons dashicons-info-outline"></span> About Aulapress</h1>
	</div>
<?php
}
