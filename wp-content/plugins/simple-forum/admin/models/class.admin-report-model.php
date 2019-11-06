<?php

class SPF_Admin_Report {
    public static function get_reports() {
        global $wpdb;
        $query = "SELECT
            SPF_REPORTS.id,
            SPF_REPORTS.post_id,
            SPF_REPORTS.report AS reason, 
            SPF_REPORTS.reporter_id, 
            SPF_ACCOUNTS.username AS post_owner, 
            SPF_POSTS.post_content,
            SPF_POSTS.topic_id
            FROM SPF_REPORTS 
            INNER JOIN SPF_ACCOUNTS 
            ON SPF_REPORTS.reporter_id = SPF_ACCOUNTS.id
            INNER JOIN SPF_POSTS
            ON SPF_REPORTS.post_id = SPF_POSTS.id";
        return $wpdb->get_results($query);
    }

    public static function delete_report($report_id) {
        global $wpdb;
        $where = array(
            'id' => $report_id
        );

        // Si no se borra nada
        if (!$wpdb->delete('SPF_REPORTS', $where)) {
            return false;
        }

        return true;
    }
}
