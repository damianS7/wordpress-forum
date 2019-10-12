<?php

class SimpleForumAdmin {

    function __construct() {

    }

    public function plugin_menu() {		
        add_menu_page('SimpleForum', 'SimpleForum', 'manage_options', 'simple-forum-basic', array($this, 'view_basic') );
        add_submenu_page( 'simple-forum-basic', 'SimpleForum', 'Basic', 'manage_options', 'simpleforum-basic', array($this, 'view_basic' ) );
        add_submenu_page( 'simple-forum-basic', 'SimpleForum', 'Captcha', 'manage_options', 'simpleforum-captcha', array($this, 'view_basic' ) );
        add_submenu_page( 'simple-forum-basic', 'SimpleForum', 'Security', 'manage_options', 'simpleforum-security', array($this, 'view_basic' ) );
        add_submenu_page( 'simple-forum-basic', 'SimpleForum', 'Advanced', 'manage_options', 'simpleforum-advanced', array($this, 'view_basic' ) );
        add_submenu_page( 'simple-forum-basic', 'SimpleForum', 'Referral', 'manage_options', 'simpleforum-referral', array($this, 'view_basic' ) );
        add_submenu_page( 'simple-forum-basic', 'SimpleForum', 'Custom', 'manage_options', 'simpleforum-custom', array($this, 'view_basic' ) );	
        add_submenu_page( 'simple-forum-basic', 'SimpleForum', 'License', 'manage_options', 'simpleforum-license', array($this, 'view_basic' ) );
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
