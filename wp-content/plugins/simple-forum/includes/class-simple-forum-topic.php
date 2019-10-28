<?php

class SimpleForumTopic {

    // Agrega un nuevo topic a una categoria
    public static function create_topic($cat_id, $author_id, $title, $content) {
        global $wpdb;
        $table = 'SPF_TOPICS';
        $data = array(
            'cat_id' => $cat_id,
            'author_id' => $author_id,
            'title' => $title
        );
        $format = array('%d', '%d','%s');

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return null;
        }

        $topic_id = $wpdb->insert_id;
        $post_id = SimpleForumTopic::add_post($topic_id, $author_id, $content);

        if ($post_id === null) {
            return null;
        }

        return $topic_id;
    }

    public static function get_posts($topic_id = 1) {
        global $wpdb;
        return $wpdb->get_results("SELECT SPF_POSTS.post_content, SPF_POSTS.posted_at, SPF_USERS.username FROM SPF_POSTS INNER JOIN SPF_USERS ON SPF_POSTS.author_id = SPF_USERS.id WHERE topic_id = '{$topic_id}'", ARRAY_A);
    }

    // Agrega un nuevo post a un topic ya iniciado
    public static function add_post($topic_id, $author_id, $content) {
        global $wpdb;
        $table = 'SPF_POSTS';
        $content = array(
            'topic_id' => $topic_id,
            'author_id' => $author_id,
            'post_content' => $content
        );
        $format = array('%d', '%d','%s');
        
        // Si no se inserta nada, se devuelve null
        if (!$wpdb->insert($table, $content, $format)) {
            return null;
        }

        // Se devuelve el id del post
        return $wpdb->insert_id;
    }

    // Devuelve una file con los datos mas importantes del topic
    public function get_topic($topic_id = 1) {
        global $wpdb;
        $query = "SELECT
            t_topics.id,
            t_topics.cat_id,
            t_topics.title,
            t_topics.created_at,
            t_users.username AS author,
            t_cats.name AS subforum 
            FROM
            SPF_TOPICS AS t_topics 
            INNER JOIN
                SPF_USERS AS t_users 
                ON t_topics.author_id = t_users.id 
            INNER JOIN
                SPF_CATEGORIES AS t_cats 
                ON t_topics.cat_id = t_cats.id 
            WHERE
                t_topics.id = '{$topic_id}'";
        return $wpdb->get_row($query);
    }
}
