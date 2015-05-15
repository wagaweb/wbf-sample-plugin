<?php

namespace WBSample;

/**
 * The plugin bootstrap file
 *
 * @link              http://www.waboot.com
 * @since             1.0.0
 * @package           Wb_Sample
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
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

try{
	$wbf_path = get_option( "wbf_path" );
	if(!$wbf_path) throw new \Exception("WBF Not Found");
	$wbf_autoloader = $wbf_path."/includes/waboot-plugin/wbf-plugin-autoloader.php";
	if(!file_exists($wbf_autoloader)){
		$wbf_autoloader = ABSPATH."wp-content/themes/waboot/wbf"."/includes/waboot-plugin/wbf-plugin-autoloader.php";
		if(!file_exists($wbf_autoloader)){
			throw new \Exception("WBF Directory Not Found");
		}
		update_option("wbf_path",ABSPATH."wp-content/themes/waboot/wbf");
	}
	require_once $wbf_autoloader;
}catch(\Exception $e){
	$plugin_path = plugin_dir_path( __FILE__ ) . "wb-sample.php"; // /!\ /!\ /!\ HEY, LOOK! EDIT THIS ALSO!! /!\ /!\ /!\
	if(is_plugin_active( $plugin_path ) ) {
		deactivate_plugins( $plugin_path );
	}
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

	if (preg_match("/widgets/", $class)) {
		$childclass = explode('\\', $class);
		$name = end($childclass);
		require_once $plugin_path."widgets/".$name.".php";
	}

	$childclass = explode('\\', $class);

	if(isset($childclass[0]) && isset($childclass[1])){
		if($childclass[0] == "WBSample" && $childclass[1] == "includes"){
			$name = end($childclass);
			$name = lcfirst(preg_replace("/_/","-",$name));
			require_once $plugin_path."includes/class-".$name.".php";
		}
	}
}