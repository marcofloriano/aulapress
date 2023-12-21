<?php
/**
 * Class and methods of the aulapress plugin upon activation
 *
 */
namespace AULAPRESS;
/**
 * When the plugin is activated, it's supposed to execute these methods
 * in order to complete needeed taks to the correct functioning of the plugin
 * 
 */
class Activation {
	/**
	 *	Perform the needed taks to the good function of the plugin
	 * 
	 * @return void
	 */
	public static function aulapress_activate() {
		
		// Creates aulapress plugin roles
		self::aulapress_create_roles();
		// Creates aulapress plugin options
		self::aulapress_create_options();
	}

	/**
	 *	Creates teacher and student roles
	 *
	 * @return void
	 */
	public static function aulapress_create_roles() {
		
		// Create a new role for the students
		$student_role         = 'aulapress_student';
		$student_display_name = 'Aulapress Student';
		$student_capabilities = array( 
			'read_courses' => true,
		);
		add_role( 'aulapress_student', 'Aulapress Student', $student_capabilities );
		
		// Create a new role for the teachers from editor base role
		$editor_role = get_role('editor');
		add_role( 'aulapress_teacher', 'Aulapress Teacher', $editor_role->capabilities );

		// Add special capabilities to the teacher role
		$teacher_role = get_role( 'aulapress_teacher' );
		$teacher_role->add_cap( 'read_courses', true);
		$teacher_role->add_cap( 'upload_files', true);
		$teacher_role->add_cap( 'delete_courses', true);
		$teacher_role->add_cap( 'edit_courses', true);
		$teacher_role->add_cap( 'create_courses', true);
		$teacher_role->add_cap( 'publish_courses', true);
		$teacher_role->add_cap( 'manage_options', true);
	}

	/**
	 *	Creates options for the front-end (public options) 
	 *	and back-end (system options) of the plugin
	 *
	 * @return void
	 */
	public static function aulapress_create_options() {

		// front-end options: autoloaded
		add_option( 'aulapress_plugin_public_options', array(
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