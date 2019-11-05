<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_ReportController {

    // Controlador para "forums.php"
    public static function view_report() {
        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post_id = SimpleForum::get_query_var('spf_id');
            $report = sanitize_text_field($_POST['report_reason']);
            $reporter_id = $_SESSION['account']->id;
            SPF_Report::add_report($post_id, $report, $reporter_id);
        }
        return SimpleForum::view('report.php', $data);
    }
}
