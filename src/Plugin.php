<?php

namespace WBSample;
use WBF\components\pluginsframework\BasePlugin;
use WBF\components\utils\Utilities;
use WBSample\includes\Loader;

/**
 * The core plugin class.
 *
 * @package    WBSample
 * @subpackage WBSample/includes
 */
class Plugin extends BasePlugin {
	/**
	 * @var Loader
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		parent::__construct( "waboot-sample", plugin_dir_path( dirname(  __FILE__  ) ) );

		/*
		 * Now you have a reference to this plugin instance in $GLOBALS['wbf_loaded_plugins']['waboot-sample']
		 * You can use this instance to make plugins talk to each other or to use plugins methods in templates.
		 */

		$this->get_loader()->add_action( 'init', $this, 'hello_world' );

		/*
		 * Every actions and filters added through $this->loader is stored in $this->loader->actions and $this->loader->filters.
		 * They are hooked to WP once you call $this->run()
		 */

		/*
		 * Now we can load modules
		 */

		$this->loader->register_module('sample');
	}

	public function hello_world(){
		var_dump("Hello World! I'm: ".$this->get_plugin_name());
	}

	/**
	 * Loads plugin dependecies, called durint parent::__construct().
	 */
	public function load_dependencies() {
		//Load Notice Manager if needed
		$wbf_notice_manager = Utilities::get_wbf_notice_manager();
		$this->notice_manager = &$wbf_notice_manager;

		$this->loader = new Loader($this,__NAMESPACE__);
	}
}
