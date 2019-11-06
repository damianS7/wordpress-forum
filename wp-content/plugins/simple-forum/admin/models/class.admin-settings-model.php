<?php

// Esta clase interaccion con la tabla "SPF_SETTINGS"
class SPF_AdminSetting {
    public static function get_settings() {
        global $wpdb;
        $query = "SELECT name, value FROM SPF_SETTINGS";
        return $wpdb->get_results($query);
    }

    // Este metodo actualiza el valor de una opcion
    public static function update_setting($name, $value) {
        global $wpdb;
        
        $data = array(
            'value' => $value
        );
        
        $where = array(
            'name' => $name
        );

        if (!$wpdb->update('SPF_SETTINGS', $data, $where)) {
            return false;
        }
        return true;
    }
}
