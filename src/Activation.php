<?php
/**
 * Class and methods of the aulapress plugin upon activation
 *
 */

namespace AULAPRESS;

/**
 * When the plugin is activate, it's supposed to execute these methods
 * in order to complete needeed taks to the correct functioning of the plugin
 * 
 */
class Activation {
	/**
	 *	Perform the neededd taks to the good function of the plugin
	 * 
	 * @return void
	 */
	public static function aulapress_activate() {
		// Create a new role for the students
		$student_role         = 'aulapress_student';
		$student_display_name = 'Aulapress Student';
		$student_capabilities = array( 
			'read'         => true,
			'read_courses' => true
		);
		add_role( $student_role, $student_display_name, $student_capabilities );
		// Create a new role for the teachers
		$teacher_role         = 'aulapress_teacher';
		$teacher_display_name = 'Aulapress Teacher';
		$teacher_capabilities = array( 
			'delete_courses'         => true, 
			'edit_courses'           => true, 
			'publish_courses'        => true, 
			'read'                   => true, 
			'read_courses'           => true, 
			'upload_files'           => true
		);
		add_role( $teacher_role, $teacher_display_name, $teacher_capabilities );
		// Gets the administrator role object and adds a custom capability to it
		$administrador_role = get_role( 'administrator' );
		if( ! empty( $administrador_role ) ) {
			$administrador_role->add_cap( 'aulapress_teacher' );
		}
	}
}