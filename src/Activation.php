<?php

namespace AULAPRESS;

class Activation {
	public static function activate() {
		// Gets the administrator role object and adds a custom capability to it
		$role = get_role('administrator');

		if(!empty($role)) {
			$role->add_cap('aulapress_instructor');
		}
	}
}