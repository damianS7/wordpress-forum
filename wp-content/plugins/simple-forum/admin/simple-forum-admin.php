<?php
require_once(PLUGIN_DIR . 'admin/controllers/class.admin-forum-controller.php');
require_once(PLUGIN_DIR . 'admin/models/class.admin-forum-model.php');

class SimpleForumAdmin {
    public function __construct() {
    }

    public function plugin_menu() {
        add_menu_page('SimpleForum', 'Simple Forum', 'manage_options', 'simpleforum-menu', array($this, 'view_settings'));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Moderation', 'manage_options', 'simpleforum-moderation', array($this, 'view_moderation' ));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Users', 'manage_options', 'simpleforum-users', array($this, 'view_users' ));
        add_submenu_page('simpleforum-menu', 'SimpleForum', 'Forums', 'manage_options', 'simpleforum-forums', array($this, 'view_forums' ));
    }

    public function view_settings() {
        include_once(PLUGIN_DIR . 'admin/views/settings.php');
    }

    public function view_moderation() {
        include_once(PLUGIN_DIR . 'admin/views/moderation.php');
    }

    public function view_users() {
        include_once(PLUGIN_DIR . 'admin/views/users.php');
    }

    public function view_forums() {
        // Creacion de forum
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_forum'])) {
            $name = sanitize_text_field($_POST['name']);
            $description = sanitize_text_field($_POST['description']);
            if (SPF_AdminForum::create_forum($name, $description)) {
                $data['success_message'] = 'The forum has been created.';
            }
        }

        // Borrado de foro
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_forum'])) {
            $forum_id = sanitize_text_field($_POST['forum_id']);
            if (SPF_AdminForum::delete_forum($forum_id) !== null) {
                $data['success_message'] = 'The forum has been deleted.';
            }
        }

        $data['forums'] = SPF_AdminForum::get_forums();
        SimpleForumAdmin::view('forums.php', $data);
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
    }
}
