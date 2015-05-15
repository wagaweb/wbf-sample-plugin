<?php

namespace WBSample\pub;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WBProperty
 * @subpackage WBProperty/public
 */
class Pub {

	/**
	 * The main plugin class
	 * @var
	 */
	private $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param null|string $plugin_name @deprecated
	 * @param null|string $version @deprecated
	 * @param null $core The plugin main object
	 */
	public function __construct( $plugin_name = null, $version = null, $core = null ) {
		if(isset($core)) $this->plugin = $core;
	}

	public function styles(){
		if($this->plugin->is_debug()){
			//...
		}else{
			//...
		}
	}

	public function scripts(){
		if($this->plugin->is_debug()){
			//...
		}else{
			//...
		}
	}

	public function register_post_type(){}

	public function rewrite_tags(){}

	public function rewrite_rules(){}

	/**
	 * WIDGETS
	 */

	public function widgets(){
		//...
	}

    /**
     * SHORTCODES
     */

    public function shortcodes(){
	    //...
    }
}