<?php

class SPF_Admin_Report {
    public static function get_reports() {
        global $wpdb;
        $query = "SELECT
            SPF_REPORTS.id,
            SPF_REPORTS.report AS reason, 
            SPF_ACCOUNTS.username AS post_owner, 
            SPF_POSTS.post_content
            FROM SPF_REPORTS 
            INNER JOIN SPF_ACCOUNTS 
            ON SPF_REPORTS.reporter_id = SPF_ACCOUNTS.id
            INNER JOIN SPF_POSTS
            ON SPF_REPORTS.post_id = SPF_POSTS.id";
        return $wpdb->get_results($query);
    }
}
