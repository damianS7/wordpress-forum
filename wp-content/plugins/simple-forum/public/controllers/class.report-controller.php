<?php

// Controlador para "reports.php"
class SPF_ReportController {

    // Logica principal de la vista
    public static function view_report() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return SPF_ReportController::render(SPF_ReportController::handle_forms());
        }
        
        return SPF_ReportController::render();
    }

    // Metodo para procesar los formularios (POST)
    public static function handle_forms() {
        $reporter_id = $_SESSION['account']->id;
        $post_id = SimpleForum::get_query_var('spf_id');
        $report = sanitize_text_field($_POST['report_reason']);

        // Si el usuario deja en blanco el campo de texto ...
        if (empty($report)) {
            return array('error_message' => 'You must specify a reason.');
        }

        if (SPF_Report::add_report($post_id, $report, $reporter_id)) {
            return array('success_message' => 'Your report has been sent.');
        } else {
            return array('error_message' => 'Sorry we cannot process your report.');
        }
    }

    // Metodo para renderizar la vista.
    public static function render($data = array()) {
        return SimpleForum::view('report.php', $data);
    }
}