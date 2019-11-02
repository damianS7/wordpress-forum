<?php
// Esta clase sirve para obtener informacion de la base de datos relacionados a las
// cuentas de usuarios
class SPF_Account {
    
    // Metodo que comprueba la existencia de un email en la tabla ACCOUNTS
    public static function mail_exists($mail) {
        global $wpdb;
        $query = "SELECT email 
            FROM SPF_ACCOUNTS 
            WHERE email = '{$mail}'";

        // El metodo get_row devuelve null cuando no se encuentran resultados
        // Por lo tanto el correo no se encuentra en uso.
        if ($wpdb->get_row($query) === null) {
            return false;
        }
        return true;
    }

    // Metodo que comprueba si un nombre de usuario existe en la base de datos
    public static function username_exists($username) {
        // Si no podemos encontrar ninguna cuenta asociada a este usuario ...
        if (SPF_Account::get_account($username) === null) {
            return false; // El nombre de usuario no esta ne uso
        }

        // El nombre de usuario esta ocupado
        return true;
    }

    // Esta funcion devuelve una unica file que contiene informacion del usuario
    public static function get_account($username) {
        global $wpdb;
        $query = "SELECT id, username, password, email 
            FROM SPF_ACCOUNTS 
            WHERE username = '{$username}'";

        return $wpdb->get_row($query);
    }

    // Esta funcion inserta una nueva cuenta en la base de datos
    // Si no es posible insertar la file en la base de datos
    // la funcion devuelve false. Si tiene exito, devolvera el id de la cuenta
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

        // Devolvemos el ultimo id insertado, que es el id de la cuenta
        return $wpdb->insert_id;
    }

    // Este metodo se encarga de actualizar los datos de una cuenta de usuario
    public static function update_account($user_id, $username, $password, $email) {
        global $wpdb;
        
        $data = array(
            'username' => $username,
            'password' => $password,
            'email' => $email
        );
        
        $where = array(
            'id' => $user_id
        );

        if (!$wpdb->update('SPF_ACCOUNTS', $data, $where)) {
            return false;
        }
        return true;
    }
}
