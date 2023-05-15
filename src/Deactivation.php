<?php
/**
 * Class and methods of the aulapress plugin upo deactivation
 *
 */
namespace AULAPRESS;
/**
 * When the plugin is deactivated, it's supposed to execute these methods
 * 
 */
class Deactivation {
	/**
	 *	Perform the neededd taks to the good function of the plugin
	 * 
	 * @return void
	 */	 
	public static function aulapress_deactivate() {

		// Removes the roles created by the plugin upon activation
		remove_role( 'aulapress_teacher' );
		remove_role( 'aulapress_student' );

		//returns false if the option to delete cannot be found
		delete_option( 'aulapress_plugin_options' );
		delete_option( 'aulapress_plugin_admin_options' );
	}
}