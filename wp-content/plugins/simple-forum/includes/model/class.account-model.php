<?php

class SPF_Account {
    public static function get_account($username) {
        global $wpdb;
        $query = "SELECT id, username, password, email 
            FROM SPF_ACCOUNTS 
            WHERE username = '{$username}' 
            AND password = '{$password}'";

        return $wpdb->get_row($query);
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
