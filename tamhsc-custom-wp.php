<?php
/*
	Plugin Name:        TAMHSC Customization
	Plugin URI:         https://github.com/tamhsc/tamhsc-custom-wp
	Description:        Basic customization for Wordpress, TAMHSC branded login, disable password reset, etc.
	Version:            1.4.7
	Author:             Jeremy Tarpley
	License:            GNU General Public License v2
	License URI:        http://www.gnu.org/licenses/gpl-2.0.html
	Network:            true
	GitHub Plugin URI:  https://github.com/tamhsc/tamhsc-custom-wp
	GitHub Branch:      master
*/



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// include the code for the plugin's core functionality
require plugin_dir_path( __FILE__ ) . 'includes/core-tamhsc-custom-wp.php';

// include the code for the options page
require plugin_dir_path( __FILE__ ) . 'includes/options.php';

?>
