<?php

namespace WBSample;

function get_wbf_path(){
	$wbf_path = get_option( "wbf_path" );
	if(!$wbf_path) throw new \Exception("WBF Not Found");
	return $wbf_path;
}

function get_autoloader(){
	$wbf_path = get_wbf_path();
	$wbf_autoloader = $wbf_path."/includes/waboot-plugin/wbf-plugin-autoloader.php";
	if(!file_exists($wbf_autoloader)){
		$wbf_autoloader = ABSPATH."wp-content/themes/waboot/wbf"."/includes/waboot-plugin/wbf-plugin-autoloader.php";
		if(!file_exists($wbf_autoloader)){
			throw new \Exception("WBF Directory Not Found");
		}
		update_option("wbf_path",ABSPATH."wp-content/themes/waboot/wbf");
	}
	return $wbf_autoloader;
}

function disable_plugin($plugin){
	if(!function_exists("is_plugin_active")){
		include_once(ABSPATH.'wp-admin/includes/plugin.php');
	}
	if(is_plugin_active( $plugin ) ) {
		deactivate_plugins( $plugin );
		if(is_admin()){
			add_action( 'admin_notices', function(){
				?>
				<div class="error">
					<p><?php _e( __FILE__. ' was disabled due it requires Waboot Framework' ); ?></p>
				</div>
			<?php
			});
		}
	}
}