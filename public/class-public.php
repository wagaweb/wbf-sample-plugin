<?php

namespace WBSample\pub;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    WBSample
 * @subpackage WBSample/public
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
		/*
         * UNCOMMENT AND EDIT THESE LINES
         */

		//wp_enqueue_style('wb-sample-style', $this->plugin->get_uri() . 'public/assets/dist/css/wb-sample.min.css');
	}

	public function scripts(){
		/*
		 * UNCOMMENT AND EDIT THESE LINES
		 */

		/*if($this->plugin->is_debug()){
			wp_register_script('wb-sample', $this->plugin->get_uri() . 'public/assets/src/js/bundle.js', array('jquery','backbone','underscore'), false, true);
		}else{
			wp_register_script('wb-sample', $this->plugin->get_uri() . 'public/assets/dist/js/wb-sample.min.js', array('jquery','backbone','underscore'), false, true);
		}

		$localize_args = array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'blogurl' => get_bloginfo("wpurl"),
			'isAdmin' => is_admin()
		);

		wp_localize_script('wb-sample','wbData',$localize_args);
		wp_enqueue_script('wb-sample');*/
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