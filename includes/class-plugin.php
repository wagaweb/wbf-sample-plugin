<?php

namespace WBSample\includes;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WBSample
 * @subpackage WBSample/includes
 */
class Plugin extends \Waboot_Template_Plugin {

	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		parent::__construct( "wb-sample", plugin_dir_path( dirname( __FILE__ ) ) );

		//Setting the update server:
		//$this->set_update_server("http://update.waboot.org/?action=get_metadata&slug={$this->plugin_name}&type=plugin");

		$this->define_public_hooks();
		$this->define_admin_hooks();

		//Adding a template selectable from the dashboard:
		//$this->add_template( "sample.php", __( "Sample", $this->plugin_name ), $this->plugin_dir . "/public/templates/sample.php" );

		//Adding a template injected into Wordpress template system:
		//$this->add_cpt_template( "single-sample.php", $this->plugin_dir . "/public/templates/single-sample.php" );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 */
	private function define_public_hooks() {
		$plugin_public = $this->loader->public_plugin;
		$this->loader->add_action( 'widgets_init', $plugin_public, 'widgets' );
		$this->loader->add_action( 'init', $plugin_public, 'register_post_type' );
		$this->loader->add_action( 'init', $plugin_public, 'shortcodes' );
		$this->loader->add_action( 'init', $plugin_public, 'rewrite_tags' );
		$this->loader->add_action( 'init', $plugin_public, 'rewrite_rules' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'scripts' );

		/*
		 * FOR WBF <= 0.11.0 ONLY
		 *
		 * If you want to use wbf_get_template_part in a plugin template, you must specify a filter like that, where the string following "path:"
		 * is the string used in wbf_get_template_part. In the following example, the filter works for calls like: wbf_get_template_part('/templates/parts/content')
		 */
		//$this->loader->add_filter( 'wbf/get_template_part/path:/templates/parts/content', $plugin_public, 'get_template_part_override', 10, 2 );
	}

	/**
	 * Register all of the hooks related to the admin-facing functionality of the plugin.
	 */
	private function define_admin_hooks(){
		$plugin_admin = $this->loader->admin_plugin;
	}

	/**
	 * Load the required dependencies for this plugin (called into parent::_construct())
	 */
	protected function load_dependencies() {
		parent::load_dependencies();
	}

	public static function get_posts_non_intensive(\closure $callback,$args = array()){
		//Query all posts in an non-intensive way
		$page = 1;
		$get_posts = function($args) use(&$page){
			$args = wp_parse_args($args,array(
				'paged' => $page,
			));
			$all_posts = new \WP_Query($args);
			if(count($all_posts->posts) > 0){
				return $all_posts;
			}else{
				return false;
			}
		};
		while($all_posts = $get_posts($args)){
			$i = 0;
			while($i <= count($all_posts->posts)-1){ //while($all_posts->have_posts()) WE CANNOT USE have_posts... too many issue
				//if($i == 1) $all_posts->next_post(); //The first next post does not change $all_posts->post for some reason... so we need to do it double...
				$p = $all_posts->posts[$i];
				call_user_func($callback,$p);
				//if($i < count($all_posts->posts)) $all_posts->next_post();
				$i++;
			}
			$page++;
		}
	}

	public static function get_paged(){
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$page_uri_values = waboot_get_uri_path_after("page");
		if(is_array($page_uri_values) && !empty($page_uri_values)){
			$paged = (int) $page_uri_values[0];
		}

		return $paged;
	}
}
