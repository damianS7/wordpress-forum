<?php

class SPF_Auth {
    public static function auth($username, $password) {
        global $wpdb;
        $query = "SELECT id, username, password, email 
            FROM SPF_ACCOUNTS 
            WHERE username = '{$username}' 
            AND password = '{$password}'";

        $row = $wpdb->get_row($query);

        if ($row === null) {
            return false;
        }

        $_SESSION['account'] = $row;
        return true;
    }

    public static function logout() {
        if (isset($_SESSION['account'])) {
            unset($_SESSION['account']);
        }
    }

    public static function is_auth() {
        if (isset($_SESSION['account'])) {
            if (!empty($_SESSION['account']->id)) {
                return true;
            }
        }
        return false;
    }
}
