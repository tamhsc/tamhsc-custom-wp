<?php
/*
Plugin Name: TAMHSC Customizations
Description: Basic customization for wordpress, TAMHSC branded login, disable password reset, etc.
Version: 1.3.3
Author: Jeremy Tarpley
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/tamhsc/tamhsc-custom-wp
GitHub Branch:     master
*/



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// include the code for the options page
require plugin_dir_path( __FILE__ ) . 'options.php';


/**************Security basics**************/

	// Obscure login screen error messages from http://www.wpfunction.me/
	function tamhsc_login_obscure(){ return '<strong>Sorry</strong> your login failed!';}
	add_filter( 'login_errors', 'tamhsc_login_obscure' );

	// Disable the theme / plugin text editor in Admin
	define('DISALLOW_FILE_EDIT', true);

	//remove WP version number
	remove_action('wp_head', 'wp_generator');


	//disable password reset
	function tamhsc_disable_reset_lost_password() {
		return false;
	}
	add_filter( 'allow_password_reset', 'tamhsc_disable_reset_lost_password');


	/*
		Disable pingbacks and trackbacks
		From code available at http://wordpress.stackexchange.com/questions/31943/is-there-a-way-to-completely-turn-off-pingbacks-trackbacks
		Description: Disable XMLRPC advertising/functionality blog-wide.
		Author: EarnestoDev, http://earnestodev.com/
	*/
	// Disable X-Pingback HTTP Header.
	add_filter('wp_headers', function($headers, $wp_query){
		if(isset($headers['X-Pingback'])){
			// Drop X-Pingback
			unset($headers['X-Pingback']);
		}
		return $headers;
	}, 11, 2);

	// Disable XMLRPC by hijacking and blocking the option.
	add_filter('pre_option_enable_xmlrpc', function($state){
		return '0'; // return $state; // To leave XMLRPC intact and drop just Pingback
	});

	// Remove rsd_link from filters (<link rel="EditURI" />).
	add_action('wp', function(){
		remove_action('wp_head', 'rsd_link');
	}, 9);

	// Hijack pingback_url for get_bloginfo (<link rel="pingback" />).
	add_filter('bloginfo_url', function($output, $property){
		return ($property == 'pingback_url') ? null : $output;
	}, 11, 2);

	// Just disable pingback.ping functionality while leaving XMLRPC intact?
	add_action('xmlrpc_call', function($method){
		if($method != 'pingback.ping') return;
		wp_die(
			'Pingback functionality is disabled on this Blog.',
			'Pingback Disabled!',
			array('response' => 403)
		);
	});


/**************Generic interface clean up**************/

	// Remove support for post formats
	function tamhsc_remove_post_format() {
		// This will remove support for post formats on ALL Post Types
		remove_theme_support( 'post-formats' );
		add_filter( 'show_post_format_ui', '__return_false' );
	}
	// Use the after_setup_theme hook with a priority of 11 to load after the
	// parent theme, which will fire on the default priority of 10
	add_action( 'after_setup_theme', 'tamhsc_remove_post_format', 11 );


	function tamhsc_remove_post_meta_boxes() {
		/* Custom fields meta box. */
		remove_meta_box( 'postcustom', 'post', 'normal' );

		/* Comments meta box. */
		remove_meta_box( 'commentsdiv', 'post', 'normal' );

		/* Sharing meta box */
		remove_meta_box( 'sharing_meta', 'post', 'advanced' );
	}
	//remove post metaboxes that we don't use
	add_action( 'add_meta_boxes', 'tamhsc_remove_post_meta_boxes' );


	// Custom admin dashboard header logo
	function tamhsc_custom_admin_logo() {
	echo '<style type="text/css">
			#wpcontent #wpadminbar > #wp-toolbar > #wp-admin-bar-root-default #wp-admin-bar-wp-logo > .ab-item .ab-icon {
				display: block;
				background-image: url(https://webassets.tamhsc.edu/global-assets/images/logos/tamu-small-atm-logo.png) !important;
				background-color: #222;
				background-size: auto 20px;
				background-position: 0 6px;
				background-repeat: no-repeat;
				width: 30px;
			}
			#wpcontent #wpadminbar > #wp-toolbar > #wp-admin-bar-root-default #wp-admin-bar-wp-logo > .ab-item .ab-icon,
			#wpcontent #wpadminbar > #wp-toolbar > #wp-admin-bar-root-default #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
				font: 1px sans-serif !important;
			}
		  </style>';
	}
	add_action('admin_head', 'tamhsc_custom_admin_logo');


	// hide certain menu items from non-admin users
	function tamhsc_hide_menus_from_nonadmin() {
		if ( ! current_user_can('activate_plugins') ) {
			remove_menu_page( 'jetpack' );
			remove_menu_page( 'tools.php');
			remove_menu_page( 'options-general.php'); //settings
			remove_menu_page( 'link-manager.php' );
		}
	}
	add_action('jetpack_admin_menu', 'tamhsc_hide_menus_from_nonadmin');


	// add our favicon
	function tamhsc_blog_favicon() {
		echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('wpurl').'http:tamhsc.edu/favicon.ico" />';
	}
	add_action('wp_head', 'tamhsc_blog_favicon');


	//hide most of the default dashboard widgets
	//from: http://www.wpbeginner.com/wp-tutorials/how-to-remove-wordpress-dashboard-widgets/
	//and http://codex.wordpress.org/Dashboard_Widgets_API#Advanced:_Removing_Dashboard_Widgets
	function tamhsc_remove_dashboard_widgets() {
		global $wp_meta_boxes;

		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	}
	add_action('wp_dashboard_setup', 'tamhsc_remove_dashboard_widgets' );


	//remove the welcome panel on the dashboard
	remove_action( 'welcome_panel', 'wp_welcome_panel' );





/**************HSC Login page customizations**************/

	// Custom login message (code from http://wpsnippy.com/2013/08/how-to-add-custom-text-to-wordpress-login-page/)
	function tamhsc_login_message( $message ) {
		if ( empty($message) ){
		    return "
					<p class='message'>Log in using your TAMHSC username and password.</p>
					<div id='tamhsc-legal'>
						Unauthorized use is prohibited; usage may be subject to security testing and monitoring; misuse is subject to criminal prosecution;
						and users have no expectation of privacy except as otherwise provided by applicable privacy laws.
					</div>
				";
		} else {
		    return $message;
		}
	}
	add_filter( 'login_message', 'tamhsc_login_message' );


	//change 'Username' to 'HSC Username' on login page
	//code based on example at http://wpsnipp.com/index.php/functions-php/change-register-text-to-sign-up-on-login-page/
	function tamhsc_username_text( $translated ) {
	   $translated = str_ireplace(  'Username',  'TAMHSC Username',  $translated );
	   return $translated;
	}
	add_filter(  'gettext',  'tamhsc_username_text'  );
	add_filter(  'ngettext',  'tamhsc_username_text'  );


	function tamhsc_login_logo() { ?>
	<style type="text/css">
	    #login {
	      width: 320px;
	    }
	    body.login div#login h1 a {
	      background-image: url(https://webassets.tamhsc.edu/global-assets/images/logos/tamhsc-stacked-logo-maroon.png);
	      padding-bottom: 8px;
	      height: 105.84px;
	      width: 280px;
	    }
	    .login h1 a {
	      background-size: 280px 105.84px;
	      height: 105.84px;
	      width: 280px;
	      margin-left: auto;
	      margin-right: auto;
	    }
	    .login form {
	      margin-left: auto;
	      margin-right: auto;
	      width: 280px;
	    }
	    .login #nav, .login #backtoblog, .forgetmenot{
	      display: none;
	    }
			#tamhsc-legal {
				display: block;
				float: left;
				height: 120px;
				margin-bottom: -120px;
				position: relative;
				top: 305px;
				width: 325px;
				padding: 0 5px;
			}
	</style>
	<?php }
	add_action( 'login_enqueue_scripts', 'tamhsc_login_logo' );


	//change url and title for logo (from codex: )
	function tamhsc_login_logo_url() {
		return get_bloginfo( 'url' );
	}
	add_filter( 'login_headerurl', 'tamhsc_login_logo_url' );

	function tamhsc_login_logo_url_title() {
		return 'Texas A&amp;M Health Science Center';
	}
	add_filter( 'login_headertitle', 'tamhsc_login_logo_url_title' );



	/** DEV **/

	/*
		utility function: check a user's role
		based on code at http://docs.appthemes.com/tutorials/wordpress-check-user-role-function/
	*/
	function tamhsc_check_user_role( $role, $user_id = null ) {

		if ( is_numeric( $user_id ) )
		$user = get_userdata( $user_id );
		else
		$user = wp_get_current_user();

		if ( empty( $user ) )
		return false;

		return in_array( $role, (array) $user->roles );
	}

	/*
		Hide update notifications for non admins
		based on code available at http://premium.wpmudev.org/blog/hide-the-wordpress-update-notification/
	*/
	function tamhsc_hide_update_notice() {
		if (!current_user_can('update_core')) {
			remove_action( 'admin_notices', 'update_nag', 3 );
			remove_action('load-update-core.php','wp_update_plugins');
		}
	}
	add_action( 'admin_head', 'tamhsc_hide_update_notice', 1 );



	/*
		Allow editor's to see 'Appearance' menu and access 'Widgets' and 'Menus' submenues
		but removes ability to see updates, change theme and customize menu.
		Based on code available at
		http://stackoverflow.com/questions/25788511/remove-submenu-page-customize-php-in-wordpress-4-0
		https://wordpress.org/support/topic/remove-customize-from-admin-menu
		http://wordpress.stackexchange.com/questions/4191/allow-editors-to-edit-menus
	*/
	function tamhsc_remove_appearance_submenus() {
		//pull value set in TAMHSC Customization options page
		$options = get_option( 'tamhsc_settings' );
		$display_menu = 0;

		// if its unchecked, nothing is added to the database
		if ( !empty($options) && array_key_exists('tamhsc_checkbox_field_0', $options) ) {
			$display_menu = $options['tamhsc_checkbox_field_0'];
		}

		if ( $display_menu == 1 && tamhsc_check_user_role ( 'editor' ) ) {
			//first give editors access to the capbabilty they need
			$role_object = get_role( 'editor' );
			$role_object->add_cap( 'edit_theme_options' );

			global $submenu;
			unset($submenu['index.php'][10]); // Removes 'Updates'.
			unset($submenu['themes.php'][5]); // Removes 'Themes'
			unset($submenu['themes.php'][6]); // Remove customize link'

			// if the theme has the header and background image submenus, remove those too,
			// code from http://stackoverflow.com/questions/25788511/remove-submenu-page-customize-php-in-wordpress-4-0
			$customize_url_arr = array();
			$customize_url_arr[] = 'customize.php'; // 3.x
			$customize_url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), 'customize.php' );
			$customize_url_arr[] = $customize_url; // 4.0 & 4.1

			if ( current_theme_supports( 'custom-header' ) && current_user_can( 'customize') ) {
				$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'header_image', $customize_url ); // 4.1
				$customize_url_arr[] = 'custom-header'; // 4.0
			}
			if ( current_theme_supports( 'custom-background' ) && current_user_can( 'customize') ) {
				$customize_url_arr[] = add_query_arg( 'autofocus[control]', 'background_image', $customize_url ); // 4.1
				$customize_url_arr[] = 'custom-background'; // 4.0
			}
			foreach ( $customize_url_arr as $customize_url ) {
				remove_submenu_page( 'themes.php', $customize_url );
			}
		}
		else {
			//remove editors access to the capbabilty they need to see Appearance tab
			$role_object = get_role( 'editor' );
			$role_object->remove_cap( 'edit_theme_options' );
		}
	}
	add_action( 'admin_menu', 'tamhsc_remove_appearance_submenus', 999 );

	// disable wordpress disable auto linking of images
	// code from http://www.wpbeginner.com/wp-tutorials/automatically-remove-default-image-links-wordpress/
	function tamhsc_imagelink_setup() {
		$image_set = get_option( 'image_default_link_type' );

		if ($image_set !== 'none') {
			update_option('image_default_link_type', 'none');
		}
	}
	add_action('admin_init', 'tamhsc_imagelink_setup', 10);
?>
