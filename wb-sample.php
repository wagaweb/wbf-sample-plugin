<?php

namespace WBSample;

/**
 * The plugin bootstrap file
 *
 * @link              http://www.waboot.com
 * @since             0.0.1
 * @package           WBSample
 *
 * @wordpress-plugin
 * Plugin Name:       Wb Sample
 * Plugin URI:        http://www.waboot.com/
 * Description:       Sample Plugin for WBF
 * Version:           0.0.1
 * Author:            Jon Doe
 * Author URI:        http://www.jon.doe/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wb-sample
 * Domain Path:       /languages
 *
 *
 * [IT] Lo scheletro del plugin e composto dai file wb-sample.php, admin/class-admin.php, public/class-public.php e includes/class-plugin.php (che connette admin e public e inizializza la plugin)
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/utils.php';
try{
	$wbf_autoloader = includes\get_autoloader();
	require_once $wbf_autoloader;
}catch(\Exception $e){
	includes\maybe_disable_plugin("wb-sample/wb-sample.php"); // /!\ /!\ /!\ HEY, LOOK! EDIT THIS ALSO!! /!\ /!\ /!\
}

/********************************************************/
/****************** PLUGIN BEGIN ************************
/********************************************************/

spl_autoload_register( '\WBSample\autoloader' );
register_activation_hook( __FILE__, '\WBSample\activate' );
register_deactivation_hook( __FILE__, '\WBSample\deactivate' );

if ( get_option( "wbf_installed" ) ) : // Starts the plugin only if Waboot Framework is installed
	/**
	 * The core plugin class that is used to define internationalization,
	 * dashboard-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-plugin.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * @since    1.0.0
	 */
	function run() {
		$plugin = new includes\Plugin();
		/*
		 * [IT] Il metodo run si trova in: wbf/includes/pluginsframework/Plugin.php .
		 * Al momento non fa altro che chiamare il metodo omonimo del Loader, che a sua volta registra azioni e filtri dentro WP.
		 */
		$plugin->run();
	}
	run();
endif;

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	includes\Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
	includes\Deactivator::deactivate();
}

/**
 * Custom plugin autoloader function
 * @param $class
 */
function autoloader($class){
	$plugin_path = plugin_dir_path( __FILE__ );

	$components = explode('\\', $class);

	if (isset($components) && $components[0] == 'WBSample' && $components[1] == 'widgets') {
		$childclass = explode('\\', $class);
		$name = end($childclass);
		require_once $plugin_path."widgets/".$name.".php";
	}

	switch($class){
		case 'WBSample\pub\Pub':
			require_once plugin_dir_path( __FILE__ ) . 'public/class-public.php';
			break;
		case 'WBSample\admin\Admin':
			require_once plugin_dir_path( __FILE__ ) . 'admin/class-admin.php';
			break;
	}
}