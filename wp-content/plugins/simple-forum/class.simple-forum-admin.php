<?php

class SimpleForumAdmin {

    function __construct() {

    }

    public function plugin_menu() {		
        add_menu_page('SimpleForum', 'Simple Forum', 'manage_options', 'simpleforum-menu', array($this, 'view_basic') );
        add_submenu_page( 'simpleforum-menu', 'SimpleForum', 'Basic', 'manage_options', 'simpleforum-basic', array($this, 'view_basic' ) );
        add_submenu_page( 'simpleforum-menu', 'SimpleForum', 'Captcha', 'manage_options', 'simpleforum-captcha', array($this, 'view_basic' ) );
        add_submenu_page( 'simpleforum-menu', 'SimpleForum', 'Security', 'manage_options', 'simpleforum-security', array($this, 'view_basic' ) );
        
    }

    public function view_basic() {
        include_once( PLUGIN_DIR . 'views/basic.php' );
    }

    public function register_mysettings() {
        register_setting( 'fmk-settings-group', 'fmk' );
    }

    public function init() {
        add_action( 'admin_menu', array( $this, 'plugin_menu' ) );
        add_action( 'admin_menu', array( $this, 'register_mysettings' ) );
    }
}
