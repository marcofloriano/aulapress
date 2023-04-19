<?php
/**
 * Plugin Name: Aulapress
 * Plugin URI: https://marcofloriano.com.br/aulapress
 * Description: Transforme o WordPress em uma plataforma de ensino online
 * Version: 1.0.0
 * Author: Marco Floriano
 * Author URI: https://marcofloriano.com.br
 * License: GPL v2 or later
*/

namespace AULAPRESS;

register_activation_hook(__FILE__, function() {
    require_once plugin_dir_path(__FILE__) . 'src/Activation.php';
    Activation::activate();
});