<?php
/**
 * Isolates your uninstal code from the rest of your plugin
 * and doesn't allow arbitrary code to run from your other plugin files
 *
 */

// Checks the constant
if(! defined( 'WP_UNINSTALL_PLUGIN' )) {
	wp_die( sprintf(
		__( '%s should only be called when uninstalling the plugin.', 'aulapress' ),
		__FILE__
	));
	exit;
}

// Removes the roles created by the plugin upon activation
remove_role( 'aulapress_teacher' );
remove_role( 'aulapress_student' );

//returns false if the option to delete cannot be found
delete_option( 'aulapress_plugin_options' );