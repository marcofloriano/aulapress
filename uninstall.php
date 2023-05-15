<?php
/**
 * Isolates uninstall code from the rest of the plugin
 * and doesn't allow arbitrary code to run from other plugin files
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

// Returns false if the option to delete cannot be found
delete_option( 'aulapress_plugin_options' );
delete_option( 'aulapress_plugin_admin_options' );