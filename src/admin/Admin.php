<?php
namespace WBSample\admin;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WBSample
 * @subpackage WBSample/admin
 */
class Admin {

	/**
	 * The main plugin class
	 * @var \WBSample\includes\Plugin
	 *
	 * [IT] E' possibile utilizzare $this->plugin->public_plugin per riferirsi alla classe in class-admin.php
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name = null, $version = null, $core = null ) {
		if(isset($core)) $this->plugin = $core;
	}
}