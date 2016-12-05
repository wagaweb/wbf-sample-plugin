<?php

namespace WBSample\admin;

class Admin{
	/**
	 * @var \WBSample\Plugin
	 */
	var $plugin;
	/**
	 * @var \WBSample\admin\FooClass
	 */
	var $Foo;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param null|string $plugin_name
	 * @param null|string $version
	 * @param null|Plugin $core The plugin main object
	 */
	public function __construct( $plugin_name = null, $version = null, $core = null ) {
		if(isset($core)) $this->plugin = $core;

		$this->Foo = new FooClass();
	}

	public function hello_admin(){
		var_dump("I'm the admin part of: ".$this->plugin->get_plugin_name()."!");

		var_dump($this->Foo->hello_foo());
	}
}