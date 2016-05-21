<?php
/*
Plugin Name: gMaps List Free - Google Maps List With Street Views
Description: Create your fully customizable maps and user friendly lists of markers with our Google Maps plugin! With a Street View feature!
Version: 1.0
Author: ilnarkan
Author URI: http://www.aurum-web.ru
Text Domain: gmapsl
Domain Path: /languages
*/

//constants
define( 'GMAPSL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'GMAPSL_PLUGIN_NAME', trim( dirname( GMAPSL_PLUGIN_BASENAME ), '/' ) );
define( 'GMAPSL_PLUGIN_DIR',  dirname( __FILE__ )  );

//global variables
global $wpdb;
global $gmapsl_maps_table;
global $gmapsl_markers_table;
$gmapsl_maps_table = $wpdb->prefix . 'gmapsl_maps';
$gmapsl_markers_table = $wpdb->prefix . 'gmapsl_markers';



//activation functions
require_once GMAPSL_PLUGIN_DIR . '\inc\activate.php';
//admin menu functions
require_once GMAPSL_PLUGIN_DIR . '\inc\admin_menu.php';
//all other functions
require_once GMAPSL_PLUGIN_DIR . '\inc\helpers.php';
//all other functions
require_once GMAPSL_PLUGIN_DIR . '\inc\enqueue.php';




//activation works
register_activation_hook(__FILE__, 'gmapsl_activate');
register_deactivation_hook(__FILE__, 'gmapsl_deactivate');


add_action('admin_menu', 'gmapl_admin_menu');

















