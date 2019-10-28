<?php

class SimpleForumAdmin {

    function __construct() {

    }

    public function plugin_menu() {		
        add_menu_page('SimpleForum', 'Simple Forum', 'manage_options', 'simpleforum-menu', [$this, 'view_settings'] );
        add_submenu_page( 'simpleforum-menu', 'SimpleForum', 'Moderation', 'manage_options', 'simpleforum-moderation', [$this, 'view_moderation' ] );
        add_submenu_page( 'simpleforum-menu', 'SimpleForum', 'Users', 'manage_options', 'simpleforum-users', [$this, 'view_users' ] );
        add_submenu_page( 'simpleforum-menu', 'SimpleForum', 'Categories', 'manage_options', 'simpleforum-categories', [$this, 'view_categories' ] );
        
    }

    public function view_settings() {
        include_once( PLUGIN_DIR . 'admin/views/settings.php' );
    }

    public function view_moderation() {
        include_once( PLUGIN_DIR . 'admin/views/moderation.php' );
    }

    public function view_users() {
        include_once( PLUGIN_DIR . 'admin/views/users.php' );
    }

    public function view_categories() {
        include_once( PLUGIN_DIR . 'admin/views/categories.php' );
    }

    public function register_mysettings() {
        register_setting( 'fmk-settings-group', 'fmk' );
    }

    public function init() {
        add_action( 'admin_menu', [ $this, 'plugin_menu' ] );
        add_action( 'admin_menu', [ $this, 'register_mysettings' ] );
    }
}
