<?php

class SPF_Admin_ReportController {
    public function view_reports() {
        $data = array();

        $data['reports'] = SPF_Admin_Report::get_reports();
        SimpleForumAdmin::view('reports.php', $data);
    }
}
