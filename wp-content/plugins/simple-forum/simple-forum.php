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
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	//echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( PLUGIN_DIR . 'class.simple-forum.php' );
$spf_init = new SimpleForum();

require_once( PLUGIN_DIR . 'install.php' );
$spf_install = new SimpleForumInstall();
register_activation_hook( __FILE__, array( $spf_install, 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( $spf_install, 'plugin_deactivation' ) );
//register_uninstall_hook( __FILE__, array( $spf_install, 'plugin_uninstall' ) );

add_action( 'init', array( $spf_init, 'init' ) );

if ( is_admin() ) {
    require_once( PLUGIN_DIR . 'admin/simple-forum-admin.php' );
    $pa = new SimpleForumAdmin();
    add_action( 'init', array($pa, 'init') );
}

add_filter('query_vars', 'add_custom_vars');
function add_custom_vars($public_query_vars) {
    // Variables de la vista register.php
    $public_query_vars[] = 'spf_register_username';
    $public_query_vars[] = 'spf_register_password';
    $public_query_vars[] = 'spf_register_mail';

    // topics.php
    $public_query_vars[] = 'spf_topics_topic_id';
    $public_query_vars[] = 'spf_topics_topic_title';
    $public_query_vars[] = 'spf_topics_cat_id';
    $public_query_vars[] = 'spf_topics_user_id';
    $public_query_vars[] = 'spf_topics_post_content';

    // posts.php
    $public_query_vars[] = 'spf_posts_topic_id';
    $public_query_vars[] = 'spf_posts_user_id';
    $public_query_vars[] = 'spf_posts_content';


    // login.php

    // register.php
    $public_query_vars[] = 'spf_register_username';
    $public_query_vars[] = 'spf_register_password';
    $public_query_vars[] = 'spf_register_mail';

    // reset.php

    // forums.php

    // Otros
    $public_query_vars[] = 'spf_submit';
    return $public_query_vars;
}

