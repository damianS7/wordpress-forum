<?php
// Esta clase sirve para obtener informacion de la base de datos relacionados a las
// reportes
class SPF_Report {
    
    // Metodo para agregar reportes en la base de datos
    public static function add_report($post_id, $report, $reporter_id) {
        global $wpdb;

        $table = 'SPF_REPORTS';
        $data = array(
            'post_id' => $post_id,
            'reporter_id' => $reporter_id,
            'report' => $report
        );
        $format = array('%d', '%d', '%s');

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return false;
        }

        // Devolvemos el ultimo id insertado, que es el id de la cuenta
        return $wpdb->insert_id;
    }
}
