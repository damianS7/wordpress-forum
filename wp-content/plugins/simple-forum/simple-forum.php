<?php
/**
 * @package simple-forum
 */
/*
Plugin Name: SimpleForum
Plugin URI: 
Description: Foro muy simple para wordpress
Version: 0.1
Author: damianS7
Author URI: 
Text Domain: simple-forum
*/
@session_start();
if ( !function_exists( 'add_action' ) ) {
    exit;
}

define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( PLUGIN_DIR . 'class.simple-forum.php' );

$p = new SimpleForum();
register_activation_hook( __FILE__, array( $p, 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( $p, 'plugin_deactivation' ) );
register_uninstall_hook( __FILE__, array( $p, 'plugin_uninstall' ) );

add_action( 'init', array( $p, 'init' ) );

if ( is_admin() ) {
    require_once( PLUGIN_DIR . 'class.simple-forum-admin.php' );
    $pa = new SimpleForumAdmin();
    add_action( 'init', array($pa, 'init') );
}

if (!is_admin() ) {
    add_action( 'init', array($p, 'init') );

    $dir = plugin_dir_path( __FILE__ );
    //include($dir . "frontend/forum.php");
}   
