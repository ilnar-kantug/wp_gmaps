<?php
add_action( 'admin_init', 'gmapsl_plugin_scripts_styles' );

function gmapsl_plugin_scripts_styles(){
    wp_register_script( 'gmapsl_admin_script', plugins_url(GMAPSL_PLUGIN_NAME.'/js/gmapsl-admin-script.js'), array('jquery'),'',true);
    wp_register_style( 'gmapsl_admin_css', plugins_url(GMAPSL_PLUGIN_NAME.'/css/gmapsl-admin-styles.css') );
    wp_enqueue_style('gmapsl_admin_css');
}
















