<?php
/*
	Plugin Name: TAMHSC Customization
	Plugin URI: https://github.com/tamhsc/tamhsc-custom-wp
	Description: Basic customization for wordpress, TAMHSC branded login, disable password reset, etc.
	Version: 1.4.5
	Author: Jeremy Tarpley
	License:           GNU General Public License v2
	License URI:       http://www.gnu.org/licenses/gpl-2.0.html
	Network: true
	GitHub Plugin URI: https://github.com/tamhsc/tamhsc-custom-wp
	GitHub Branch:     master
*/



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// include the code for the plugin
require plugin_dir_path( __FILE__ ) . 'includes/class-tamhsc-custom-wp.php';

// include the code for the options page
require plugin_dir_path( __FILE__ ) . 'includes/options.php';


/*
	Begins execution of the plugin.
*/
function run_tamhsc_custom_wp() {
	$plugin = new tamhsc_custom_wp();
	$plugin->run();
}
run_tamhsc_custom_wp();
?>
