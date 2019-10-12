<?php

class SimpleForum {

    public function plugin_activation() {
        global $wpdb;


        add_option( 'fmk', '' );
    }

    public function plugin_deactivation() {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS Faucetinabox_Settings");

        delete_option( 'fmk' );
    }

    public function plugin_uninstall() {

    }

    public function init_hooks() {
        add_shortcode( 'showad', array($this, 'adshortcode') );
    }

    public function init() {
        $this->init_hooks();
    }
}
