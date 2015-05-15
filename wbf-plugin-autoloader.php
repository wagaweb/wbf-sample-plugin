<?

if ( ! function_exists( "wbf_plugin_autoload" ) ):

	function wbf_plugin_autoload( $class ) {
		$wbf_path = get_option( "wbf_path" );
		if ( $wbf_path ) {
			$plugin_main_class_dir = $wbf_path . "/includes/waboot-plugin";
			if ( preg_match( "/^Waboot_Plugin|Template_/", $class ) ) {
				$filename = "class-" . strtolower( preg_replace( "/_/", "-", $class ) ) . ".php";
				if ( is_file( $plugin_main_class_dir . "/" . $filename ) ) {
					require_once( $plugin_main_class_dir . "/" . $filename );
				}
			}
		} else {
			$plugin_path = plugin_dir_path( __FILE__ ) . "wb-property.php"; //todo: per usare sto file, capire come cambiare dinamicamente qst valore
			if ( is_plugin_active( $plugin_path ) ) {
				deactivate_plugins( $plugin_path );
			}
		}
	}

	spl_autoload_register( "wbf_plugin_autoload" );

endif;