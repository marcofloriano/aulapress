<?php

namespace AULAPRESS;

class Deactivation {
	public static function aulapress_deactivate() {
		// Removes all custom capabilities from Aulapress
		// $role = get_role( 'aulapress_teacher' );
		// if( ! empty( $role ) ) {
		// 	$role->remove_cap( 'aulapress_teacher' );
		// }
		remove_role( 'aulapress_teacher' );
		remove_role( 'aulapress_student' );
	}
}