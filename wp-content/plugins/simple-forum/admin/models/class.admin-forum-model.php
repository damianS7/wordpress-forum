<?php

class SPF_Admin_Forum {
    public static function get_forums() {
        global $wpdb;
        $query = "SELECT id, name, description FROM SPF_FORUMS";
        return $wpdb->get_results($query);
    }

    // Este metodo crea un foro en la db
    public static function create_forum($name, $description) {
        global $wpdb;
        $table = 'SPF_FORUMS';
        $data = array(
            'name' => $name,
            'description' => $description
        );
        $format = array('%s', '%s');

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return null;
        }

        return $wpdb->insert_id;
    }

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

    public static function delete_post($post_id) {
        global $wpdb;
        $where = array(
            'id' => $post_id
        );

        // Si no se borra nada
        if (!$wpdb->delete('SPF_POSTS', $where)) {
            return false;
        }

        return true;
    }
}
