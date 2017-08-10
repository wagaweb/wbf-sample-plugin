<?php

namespace WBSample\modules\sample;

use WBSample\includes\BaseModule;
use WBSample\includes\ModuleInterface;

class Module extends BaseModule implements ModuleInterface {
	public function run() {
		$this->get_loader()->add_action("init",$this,"hello_world");
	}

	/**
	 * @hooked 'init'
	 */
	public function hello_world(){
		var_dump("Hello World! I'm ".$this->get_name()." module!");
	}
}