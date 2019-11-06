<?php

class SPF_Admin_ReportController {
    public function view_reports() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->handle_forms();
        }

        return $this->render();
    }

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

            return $this->render($data);
        }
    }

    public function render($data = array()) {
        $data['reports'] = SPF_Admin_Report::get_reports();
        return SimpleForumAdmin::view('reports.php', $data);
    }
}
