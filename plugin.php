<?php 
	/*
	 * Plugin Name:       TS Tester Code
	 * Version:           1.0.0
	 * Plugin URI:        http://tuningsynesthesia.com/
	 * Description:       Test code 
	 * Author:            Author Name
	 * Author URI:        http://tuningsynesthesia.com/
	 * Requires at least: 4.2.0
	 * Tested up to:      4.6.2
	 * Plugin Type:       Piklist
	 * Text Domain:       tstc
	 * Domain Path:       /lang
	 * License:	  		  ISC
	 * @package WordPress
	 * @author Author Name
	 * @since 1.0.0
	 */

	/**
     * Get the current plugin data.
     * @since   1.0.0
     * @return  Array contains plugin data
     **/

if (!function_exists('tstc')) {
	function tstc() {

		$plugin = _get_the_plugin(__FILE__);
		$_token = $plugin['TextDomain'];
		$_version = $plugin['Version'];

		/**
		 * Constants
		 * @since   1.0.0
		 **/
		if(!defined('__TSTC_TOKEN__')) define('__TSTC_TOKEN__', $_token);
		if(!defined('__TSTC_THEME_URL__'))
			define('__TSTC_THEME_URL__', get_bloginfo('template_directory') . '/');

		/**
		 * File inclusion
		 * @since   1.0.0
		 **/
		// include the main class only once
		require_once( 'includes/class-' . $_token . '.php' );
		require_once( 'includes/class-' . $_token . '-funcs.php' );

		// activate addons one by one from modules directory REMOVE LATER
        foreach(glob(dirname(__FILE__)  . '/includes/modules/*.php') as $module){
            require_once($module);
        }
		/**
		 * Piklist Checker inclusion
		 * @since   1.0.0
		 **/
		add_action('init', 'tstc_piklist_checker', 0 );
		/**
		 * Returns the main instance of TS_PTShortcode and TS_PTShortcodeajax to prevent the need to use globals.
		 *
		 * @since  1.0.0
		 * @return object
		 */

		$instance = tstc::instance( __FILE__, $_token, $_version );
		return $instance;
	} // End tstc()
} 
/**
 * Piklist Checker: Notify users from your plugin when Piklist is not active.
 *
 * @since   0.1.0
 * @return  False when piklist is not active
 */
if (!function_exists('tstc_piklist_checker')) {
	function tstc_piklist_checker(){
		if(is_admin()) {
			include_once( 'includes/class-piklist-checker.php');
			if (!piklist_checker::check(__FILE__)) {
				return;
			}
		}
	} // End tstc_piklist_checker()
}
/**
 * Get the current plugin data.
 * @since   1.0.0
 * @return  An array contains plugin data 
 **/

if (!function_exists('_get_the_plugin')) {
    function _get_the_plugin($file) {

        if ( ! function_exists( 'get_plugins' ) )
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $plugin_folder = get_plugins( '/' . plugin_basename( dirname( $file ) ) );
        $plugin_file = basename( ( $file ) );

        return $plugin_folder[$plugin_file];

    } // End _get_the_plugin ()
}

tstc();
