<?php

if(! defined('WP_UNINSTALL_PLUGIN')) {
	wp_die(sprintf(
		__( '%s should only be called when uninstalling the plugin.', 'aulapress'),
		__FILE__
	));
	exit;
}

// Removes the Aulapress Instructor custom capability from the Administrator role
$role = get_role('administrator');
if(!empty($role)) {
	$role->remove_cap('aulapress_teacher');
}