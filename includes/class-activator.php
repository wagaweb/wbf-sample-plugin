<?php

namespace WBSample\includes;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WBSample
 * @subpackage WBSample/includes
 */
class Activator {
	public static function activate() {
		try{
			$wbf_path = \WBSample\get_wbf_path();
		}catch(\Exception $e){
			self::trigger_error($e->getMessage());
		}
	}

	public static function trigger_error($message, $errno = 0) {
		if(isset($_GET['action']) /*&& $_GET['action'] == 'error_scrape'*/) {
			echo '<strong>' . $message . '</strong>';
			exit;
		} else {
			trigger_error($message, $errno);
		}
	}
}
