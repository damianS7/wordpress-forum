<?php
require_once(PLUGIN_DIR . 'admin/controllers/class.admin-forum-controller.php');
require_once(PLUGIN_DIR . 'admin/controllers/class.admin-settings-controller.php');
require_once(PLUGIN_DIR . 'admin/controllers/class.admin-moderation-controller.php');
require_once(PLUGIN_DIR . 'admin/controllers/class.admin-account-controller.php');
require_once(PLUGIN_DIR . 'admin/models/class.admin-forum-model.php');
require_once(PLUGIN_DIR . 'admin/models/class.admin-account-model.php');
require_once(PLUGIN_DIR . 'admin/models/class.admin-settings-model.php');

class SimpleForumAdmin {
    private $forum_controller;
    private $settings_controller;
    private $account_controller;
    private $moderation_controller;

    public function __construct() {
        $this->forums_controller = new SPF_Admin_ForumController();
        $this->accounts_controller = new SPF_Admin_AccountController();
        $this->settings_controller = new SPF_Admin_SettingsController();
        $this->moderation_controller = new SPF_Admin_ModerationController();
    }

    public function plugin_menu() {
        add_menu_page('SimpleForum', 'Simple Forum', 'manage_options', 'simpleforum-menu', array($this->settings_controller, 'view_settings'));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Accounts', 'manage_options', 'simpleforum-accounts', array($this->accounts_controller, 'view_accounts' ));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Forums', 'manage_options', 'simpleforum-forums', array($this->forums_controller, 'view_forums'));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Moderation', 'manage_options', 'simpleforum-moderation', array($this->moderation_controller, 'view_moderation' ));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Settings', 'manage_options', 'simpleforum-settings', array($this->settings_controller, 'view_settings'));
    }

    public static function view($view, $data) {
        include_once(PLUGIN_DIR . 'admin/views/template.php');
    }

    public function init() {
        add_action('admin_menu', array( $this, 'plugin_menu' ));

        // jQuery
        wp_register_script('prefix_jquery', 'https://code.jquery.com/jquery-3.4.1.min.js');
        wp_enqueue_script('prefix_jquery');

        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
        
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
    }
}
