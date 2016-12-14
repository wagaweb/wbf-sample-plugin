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

		$this->loader->add_action( 'init', $this, 'register_post_type' );

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

		/*
		 * WBF will automatically check for templates linked to WordPress hierarchy under /src/templates. But you can also add them manually:
		 */
		$this->add_cpt_template("sample-post-type.php", $this->get_src_dir()."/templates/sample-post-type.php");
	}

	/**
	 * Register a new post type
	 */
	public function register_post_type(){
		register_post_type("sample-post-type", [
			'public' => true,
			'label'  => __('Sample',$this->get_textdomain())
		]);

		/*
		 * Now you can create custom template for this post type under /src/templates, like:
		 *
		 * single-sample-post-type.php
		 * sample-post-type.php
		 *
		 * The plugin will automatically loads this template either from theme or from plugin
		 */
	}
}
