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
add_action('init', 'custom_rewrite_basic');
add_filter('query_vars', 'add_custom_query_var');
add_action('init', array( $spf_init, 'init' ));

function add_custom_query_var($vars) {
    $vars[] = "spf_forum_id";
    $vars[] = "spf_topic_id";
    $vars[] = "spf_pagination";
    $vars[] = "spf_view";
    return $vars;
}

function custom_rewrite_basic() {
    // ID del post donde se encuentra nuestro shortcode
    $plugin_page_id = SimpleForum::get_setting('plugin_page_id');
    
    // Listado de "topics" de un foro
    // "example.com/wordpress/spf-forum/topics/{forum_id}/{pagination}"
    add_rewrite_rule(
        '^spf-forum/topics/([^/]*)/([^/]*)/?',
        'index.php?page_id=' . $plugin_page_id . '&spf_view=topics&spf_forum_id=$matches[1]&spf_pagination=$matches[2]',
        'top'
    );

    // "example.com/wordpress/spf-forum/topics/{forum_id}/1"
    add_rewrite_rule(
        '^spf-forum/topics/([^/]*)/?',
        'index.php?page_id=' . $plugin_page_id . '&spf_view=topics&spf_forum_id=$matches[1]&spf_pagination=1',
        'top'
    );

    // Listado de "posts" de un topic
    // "example.com/wordpress/spf-forum/posts/{topic_id}/{pagination}"
    add_rewrite_rule(
        '^spf-forum/posts/([^/]*)/([^/]*)/?',
        'index.php?page_id=' . $plugin_page_id . '&spf_view=posts&spf_topic_id=$matches[1]&spf_pagination=$matches[2]',
        'top'
    );

    // Listado de "posts" de un topic con la pagina 1 por defecto
    // "example.com/wordpress/spf-forum/posts/{topic_id}"
    add_rewrite_rule(
        '^spf-forum/posts/([^/]*)/?',
        'index.php?page_id=' . $plugin_page_id . '&spf_view=posts&spf_topic_id=$matches[1]&spf_pagination=1',
        'top'
    );

    // Muestra la vista indicada en "spf_view"
    // "example.com/spf-forum/{vista}"
    add_rewrite_rule(
        '^spf-forum/([^/]*)/?',
        'index.php?page_id=' . $plugin_page_id . '&spf_view=$matches[1]',
        'top'
    );
    
    // Vista principal por defecto "forums"
    // "example.com/wordpress/spf-forum/" -> "example.com/wordpress/spf-forum/forums"
    add_rewrite_rule(
        '^spf-forum/?',
        'index.php?page_id=' . $plugin_page_id . '&spf_view=forums',
        'top'
    );

    flush_rewrite_rules();
}
