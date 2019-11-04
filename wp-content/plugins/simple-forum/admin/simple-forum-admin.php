<?php
require_once(PLUGIN_DIR . 'admin/controllers/class.admin-forum-controller.php');
require_once(PLUGIN_DIR . 'admin/controllers/class.admin-settings-controller.php');
require_once(PLUGIN_DIR . 'admin/models/class.admin-forum-model.php');
require_once(PLUGIN_DIR . 'admin/models/class.admin-settings-model.php');

class SimpleForumAdmin {
    private $forum_controller;
    private $settings_controller;

    public function __construct() {
        $this->forum_controller = new SPF_AdminForumController();
        $this->settings_controller = new SPF_AdminSettingsController();
    }

    public function plugin_menu() {
        add_menu_page('SimpleForum', 'Simple Forum', 'manage_options', 'simpleforum-menu', array($this->settings_controller, 'view_settings'));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Settings', 'manage_options', 'simpleforum-settings', array($this->settings_controller, 'view_settings'));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Forums', 'manage_options', 'simpleforum-forums', array($this->forum_controller, 'view_forums'));
        //add_submenu_page('simpleforum-menu', 'SimpleForum', 'Moderation', 'manage_options', 'simpleforum-moderation', array($this, 'controller' ));
        //add_submenu_page('simpleforum-menu', 'SimpleForum', 'Users', 'manage_options', 'simpleforum-users', array($this, 'view_users' ));
        //add_submenu_page('simpleforum-menu', 'SimpleForum', 'Forums', 'manage_options', 'simpleforum-forums', array(new SPF_AdminForumController(), 'view_forums'));
    }

    public static function view($view, $data) {
        include_once(PLUGIN_DIR . 'admin/views/template.php');
    }

    public function register_mysettings() {
        register_setting('fmk-settings-group', 'fmk');
    }

    public function init() {
        add_action('admin_menu', array( $this, 'plugin_menu' ));
        add_action('admin_menu', array( $this, 'register_mysettings' ));

        // jQuery
        wp_register_script('prefix_jquery', 'https://code.jquery.com/jquery-3.4.1.min.js');
        wp_enqueue_script('prefix_jquery');

        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
        
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
    }
}
