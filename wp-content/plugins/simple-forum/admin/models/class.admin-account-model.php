<?php

class SPF_Admin_Account {
    public static function get_accounts() {
        global $wpdb;
        $query = "SELECT * FROM SPF_ACCOUNTS";
        return $wpdb->get_results($query);
    }

    // Esta funcion devuelve una unica file que contiene informacion del usuario
    public static function get_account($username) {
        global $wpdb;
        $query = "SELECT *
            FROM SPF_ACCOUNTS
            WHERE username LIKE '%{$username}%'";

        return $wpdb->get_results($query);
    }

    public static function delete_account($account_id) {
        global $wpdb;
        $where = array(
            'id' => $account_id
        );

        // Si no se borra nada
        if (!$wpdb->delete('SPF_ACCOUNTS', $where)) {
            return false;
        }

        return true;
    }

    public static function update_account($data, $where) {
        global $wpdb;
        
        if (!$wpdb->update('SPF_ACCOUNTS', $data, $where)) {
            return false;
        }
        return true;
    }

    public static function update_account_info($account_id, $username, $mail) {
        $data = array(
            'email' => $mail,
            'username' => $username
        );
        
        $where = array(
            'id' => $account_id
        );
        return SPF_Admin_Account::update_account($data, $where);
    }

    public static function ban_account($account_id) {
        $data = array(
            'banned' => '1'
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }

    public static function unban_account($account_id) {
        $data = array(
            'banned' => '0'
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }

    public static function confirm_account($account_id) {
        $data = array(
            'activated' => 1
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }

    public static function reset_password($account_id, $password) {
        $data = array(
            'password' => $password
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }
}
