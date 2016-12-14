<?php

namespace WBSample;
use WBF\components\pluginsframework\TemplatePlugin;

/**
 * The core plugin class.
 *
 * @package    WBSample
 * @subpackage WBSample/includes
 */
class Plugin extends TemplatePlugin {
	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		parent::__construct( "waboot-sample", plugin_dir_path( dirname(  __FILE__  ) ) );

		/*
		 * Now you have a reference to this plugin instance in $GLOBALS['wbf_loaded_plugins']['waboot-sample']
		 * You can use this instance to make plugins talk to each other or to use plugins methods in templates.
		 */

		$this->loader->add_action( 'init', $this, 'hello_world' );

		/*
		 * Every actions and filters added through $this->loader is stored in $this->loader->actions and $this->loader->filters.
		 * They are hooked to WP once you call $this->run()
		 */

		/*
		 * This will add a new template to WordPress template selector, You can specify the post type as third argument.
		 * Plugins will search the template in child and parent theme directories first.
		 * You can override the template by placing a file with the same name in:
		 * - wp-content/themes/theme-name/plugin-name/template-name.php
		 * - wp-content/themes/theme-name/templates/plugin-name/template-name.php
		 * - wp-content/themes/theme-name/templates/parts/plugin-name/template-name.php
		 *
		 * Where "theme-name" is the child or parent theme name.
		 */
		$this->add_template("Custom Page Template",$this->get_src_dir()."/templates/custom-page-template.php");
	}

	public function hello_world(){
		var_dump("Hello World! I'm: ".$this->get_plugin_name());
	}
}
