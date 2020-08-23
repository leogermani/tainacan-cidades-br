<?php
/*
Plugin Name: Custom Metadata Type
Plugin URI: https://tainacan.org/new
Description: "A Custom Metadata Type for Tainacan, that does pretty much what the Numeric metadata type does, except for step validation and a built vue component."
Author: "Your Name Here"
Version: 0.1
Text Domain: cidades-br-metadata-type
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/
add_action("tainacan-register-metadata-type", "register_metadata_type");
function register_metadata_type($helper) {

    // Registering the Class
    require_once( plugin_dir_path(__FILE__) . 'metadata_type/metadata-type.php' );

    // Registering the Vue Component
    $handle = 'cidades-br-metadata-type';
    $class_name = 'Cidades_BR_Metadata_type';
    $metadata_script_url = plugin_dir_url(__FILE__) . 'metadata_type/dist/metadata-type.bundle.js';
    $helper->register_metadata_type($handle, $class_name, $metadata_script_url);
}

add_action( 'init', function() {
    global $cidades_brasileiras, $estados_brasileiros;
    $cidades = file_get_contents( plugin_dir_url(__FILE__) . 'metadata_type/cidades.json' );
    $cidades_brasileiras = json_decode( $cidades );

    $estados = file_get_contents( plugin_dir_url(__FILE__) . 'metadata_type/estados.json' );
    $estados_brasileiros = json_decode( $estados );
} );

?>
