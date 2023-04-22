<?php
/**
 * Class and methods of the aulapress plugin upon activation
 *
 */

namespace AULAPRESS;

/**
 * When the plugin is activate, it's supposed to execute these methods
 * in order to complete needeed taks to correct function of the plugin
 * 
 */
class Activation {
	/**
	 *	Perform the neededd taks to the good function of the plugin
	 * 
	 * @return void
	 */
	public static function activate() {
		// Gets the administrator role object and adds a custom capability to it
		$role = get_role('administrator');

		if(!empty($role)) { //
			$role->add_cap('aulapress_instructor');
		}
	}
}