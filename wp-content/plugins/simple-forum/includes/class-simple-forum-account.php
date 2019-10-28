<?php

class SimpleForumAccount {
    private $username;
    private $password;
    private $email;

    public static function getAccount() {
    }

    public static function createAccount($username, $password, $email) {
        global $wpdb;

        $table = 'SPF_USERS';
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
