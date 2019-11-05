<?php
/**
 * Plugin Name: SimpleForum
 * Plugin URI:
 * Description: A basic forum for wordpress
 * Version: 0.1
 * Author: damianS7
 * Author URI:
 * Text Domain: simple-forum
 *
 */


// Impedimos el acceso si se intenta acceder directamente al plugin
if (!function_exists('add_action')) {
    exit;
}

define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));

// BACKEND (WP-ADMIN)
if (is_admin()) {
    require_once(PLUGIN_DIR . 'install.php');
    $install = new SimpleForumInstall();
    register_activation_hook(__FILE__, array( $install, 'plugin_activation' ));
    register_deactivation_hook(__FILE__, array( $install, 'plugin_deactivation' ));
    //register_uninstall_hook( __FILE__, array( $spf_install, 'plugin_uninstall' ) );

    require_once(PLUGIN_DIR . 'admin/simple-forum-admin.php');
    $admin = new SimpleForumAdmin();
    add_action('init', array($admin, 'init'));
}

// FRONTEND
if (!is_admin()) {
    require_once(PLUGIN_DIR . 'public/class.simple-forum.php');
    $public = new SimpleForum();
    add_action('init', array( $public, 'init_hooks' ));
}
