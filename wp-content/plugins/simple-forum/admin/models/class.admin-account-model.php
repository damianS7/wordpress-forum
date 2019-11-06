<?php

// Clase para interacturar con la tabla "SPF_ACCOUNTS"
class SPF_Admin_Account {
    // Metodo para obtener todas las cuentas de la tabla
    public static function get_accounts() {
        global $wpdb;
        $query = "SELECT * FROM SPF_ACCOUNTS";
        return $wpdb->get_results($query);
    }

    // Esta metodo devuelve las filas que contiene informacion del usuario indicado
    public static function get_account($username) {
        global $wpdb;
        $query = "SELECT *
            FROM SPF_ACCOUNTS
            WHERE username LIKE '%{$username}%'";

        return $wpdb->get_results($query);
    }

    // Este metodo borra una cuenta. Retorna false si no se borra la cuenta indicada.
    public static function delete_account($account_id) {
        global $wpdb;
        $where = array(
            'id' => $account_id
        );

        // Si no se consigue borrar ...
        if (!$wpdb->delete('SPF_ACCOUNTS', $where)) {
            return false;
        }

        return true;
    }

    // Este metodo actualiza la tabla con los datos indicados en $data y $where.
    // Retorna false si no se puede actualizar.
    public static function update_account($data, $where) {
        global $wpdb;
        
        if (!$wpdb->update('SPF_ACCOUNTS', $data, $where)) {
            return false;
        }
        return true;
    }

    // Actualiza el nombre de usuario y email de una cuenta.
    // Retorna false si no se puede actualizar
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

    // Banea una cuenta de usuario. Retorna false si no es posible banear la cuenta.
    public static function ban_account($account_id) {
        $data = array(
            'banned' => '1'
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }


    // Quita el ban a una cuenta. Retorna false si hay un error.
    public static function unban_account($account_id) {
        $data = array(
            'banned' => '0'
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }

    // Activa una cuenta de usuario. Retorna false si no consigue activarse.
    public static function activate_account($account_id) {
        $data = array(
            'activated' => 1
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }

    // Actualiza el password de una cuenta de usuario. Retorna false si no puede.
    public static function update_password($account_id, $password) {
        $data = array(
            'password' => $password
        );
        
        $where = array(
            'id' => $account_id
        );

        return SPF_Admin_Account::update_account($data, $where);
    }
}
