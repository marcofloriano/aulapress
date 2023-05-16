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
		
		// Creates aulapress plugin roles
		self::aulapress_create_roles();
		// Creates aulapress plugin options
		self::aulapress_create_options();
	}

	public static function aulapress_create_roles() {
		// Create a new role for the students
		$student_role         = 'aulapress_student';
		$student_display_name = 'Aulapress Student';
		$student_capabilities = array( 
			'read' => true
		);
		add_role( 'aulapress_student', 'Aulapress Student', $student_capabilities );
		// Create a new role for the teachers
		$teacher_role         = 'aulapress_teacher';
		$teacher_display_name = 'Aulapress Teacher';
		$teacher_capabilities = array(
			'read'         => true, 
			'upload_files' => true
		);
		add_role( $teacher_role, $teacher_display_name, $teacher_capabilities );
	}

	public static function aulapress_create_options() {

		// front-end options: autoloaded
		add_option( 'aulapress_plugin_options', array(
			'color'    => 'green',
			'fontsize' => '100%',
			'border'   => '1px solid black'
			)
		);

		// back-end options: loaded only if explicitly needed
		add_option( 'aulapress_plugin_admin_options', array(
			'version'          => '1.0',
			'donate_url'       => 'https://marcofloriano.com.br',
			'advanced_options' => '1'
			),
		'', 'no'
		);
	}
}