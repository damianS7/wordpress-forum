<?php

// Controlador de la vista "reports.php"
class SPF_Admin_ReportsController {
    public function view_reports() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->render($this->handle_forms());
        }

        return $this->render();
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        $report_id = sanitize_text_field($_POST['report_id']);
        // BAN
        if (isset($_POST['ban_account'])) {
            $account_id = sanitize_text_field($_POST['account_id']);
            if (SPF_Admin_Account::ban_account($account_id)) {
                if (SPF_Admin_Report::delete_report($report_id)) {
                    $data['success_message'] = 'The account has been banned.';
                }
            }
        }

        // Archive report
        if (isset($_POST['archive_report'])) {
            if (SPF_Admin_Report::delete_report($report_id)) {
                $data['success_message'] = 'The report has been archived.';
            }
        }
        return $data;
    }

    // Metodo para renderizar la vista.
    public function render($data = array()) {
        $data['reports'] = SPF_Admin_Report::get_reports();
        return SimpleForumAdmin::view('reports.php', $data);
    }
}
