<?php

class SimpleForumAccount {
    private $username;
    private $password;
    private $email;

    public static function get_account() {
    }

    public static function create_account($username, $password, $email) {
        global $wpdb;

        $table = 'SPF_ACCOUNTS';
        $data = array(
                'username' => $username,
                'password' => $password,
                'email' => $email
        );
        $format = array('%s', '%s','%s');

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return false;
        }

        return $wpdb->insert_id;
    }
}
