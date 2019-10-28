<?php
/*
Plugin Name: SimpleForum
Plugin URI:
Description: A basic forum for wordpress
Version: 0.1
Author: damianS7
Author URI:
Text Domain: simple-forum
*/
// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    //echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));

if (is_admin()) {
    require_once(PLUGIN_DIR . 'install.php');
    $spf_install = new SimpleForumInstall();
    register_activation_hook(__FILE__, array( $spf_install, 'plugin_activation' ));
    register_deactivation_hook(__FILE__, array( $spf_install, 'plugin_deactivation' ));
    //register_uninstall_hook( __FILE__, array( $spf_install, 'plugin_uninstall' ) );

    require_once(PLUGIN_DIR . 'admin/simple-forum-admin.php');
    $pa = new SimpleForumAdmin();
    add_action('init', array($pa, 'init'));
}

require_once(PLUGIN_DIR . 'public/class.simple-forum.php');
$spf_init = new SimpleForum();
add_action('init', array( $spf_init, 'init' ));
