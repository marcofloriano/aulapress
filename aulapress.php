<?php
/**
 * Plugin Name: Aulapress
 * Plugin URI: https://marcofloriano.com.br/aulapress
 * Description: Turns WordPress into an online teaching platform
 * Version: 1.0.0
 * Author: Marco Floriano
 * Author URI: https://marcofloriano.com.br
 * License: GPL v2 or later
*/

namespace AULAPRESS;

/**
 * Register the activation hook and calls it's activation method
 * 
 */
register_activation_hook( __FILE__, function() {
    require_once plugin_dir_path( __FILE__ ) . 'src/Activation.php';
    Activation::aulapress_activate();
});

/**
 * Load the Aulapress main file from source subfolder
 * 
 */
include plugin_dir_path(__FILE__) . 'src/Aulapress.php';

/**
 * Register the deactivation hook and calls it's deactivation method
 */
register_deactivation_hook( __FILE__, function(){
    require_once plugin_dir_path( __FILE__ ) . 'src/Deactivation.php';
    Deactivation::aulapress_deactivate();
});

