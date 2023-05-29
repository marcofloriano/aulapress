<?php
/**
 * Isolates uninstall code from the rest of the plugin
 * and doesn't allow arbitrary code to run from other plugin files
 *
 */
if(! defined( 'WP_UNINSTALL_PLUGIN' )) {
	wp_die( sprintf(
		__( '%s should only be called when uninstalling the plugin.', 'aulapress' ),
		__FILE__
	));
	exit;
}

/**
 * Removes the roles created by the plugin upon activation
 *
 */
remove_role( 'aulapress_teacher' );
remove_role( 'aulapress_student' );

/**
 * Removes the options created by the plugin upon activation 
 * for users (public) and plugin (admin)
 *
 */
delete_option( 'aulapress_plugin_public_options' );
delete_option( 'aulapress_plugin_admin_options' );

/**
 * Remove Aulapress settings and clean the database
 *
 */
// Clean de-registration of registered setting
unregister_setting( 'aulapress_plugin_options', 'aulapress_plugin_options' );
// Remove saved options from the database
delete_option( 'aulapress_plugin_options' );