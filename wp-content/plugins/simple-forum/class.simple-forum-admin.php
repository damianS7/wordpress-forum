<?php

class SimpleForumAdmin {

	function __construct() {

	}

	public function plugin_menu() {		
		
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
