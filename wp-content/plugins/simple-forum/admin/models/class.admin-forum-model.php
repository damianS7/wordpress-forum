<?php

// Esta clase interactura con la tabla de la base de datos "SPF_FORUMS"
class SPF_Admin_Forum {
    // Metodo para obtener todas las foros de la tabla
    public static function get_forums() {
        global $wpdb;
        $query = "SELECT id, name, description FROM SPF_FORUMS";
        return $wpdb->get_results($query);
    }

    // Este metodo crea un foro en la db
    public static function create_forum($name, $description) {
        global $wpdb;
        $data = array(
            'name' => $name,
            'description' => $description
        );

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert('SPF_FORUMS', $data, array('%s', '%s'))) {
            return null;
        }

        return $wpdb->insert_id;
    }

    // Este metodo borra un foros
    public static function delete_forum($forum_id) {
        global $wpdb;
        $where = array(
            'id' => $forum_id
        );

        // Si no se borra nada
        if (!$wpdb->delete('SPF_FORUMS', $where)) {
            return false;
        }

        return true;
    }
}
