<?php

class SPF_Forum {

    // Agrega un nuevo topic a una categoria
    public static function create_topic($forum_id, $author_id, $title, $content) {
        global $wpdb;
        $table = 'SPF_TOPICS';
        $data = array(
            'forum_id' => $forum_id,
            'author_id' => $author_id,
            'title' => $title
        );
        $format = array('%d', '%d','%s');

        // Si no se inserta nada, retornamos false
        if (!$wpdb->insert($table, $data, $format)) {
            return null;
        }

        $topic_id = $wpdb->insert_id;
        $post_id = SPF_Forum::add_post($topic_id, $author_id, $content);

        if ($post_id !== null) {
            return $topic_id;
        }
        
        return null;
    }

    public static function get_topics($forum_id = 1, $limit = 0, $offset = 3) {
        global $wpdb;
        $query = "SELECT
            t_topics.id, t_topics.title, t_topics.created_at,
            t_users.username AS author, t_cats.name AS subforum, 
            (SELECT count(*) 
                FROM SPF_POSTS 
                WHERE SPF_POSTS.topic_id=t_topics.id) AS total_posts 
            FROM SPF_TOPICS AS t_topics 
            INNER JOIN SPF_ACCOUNTS AS t_users 
            ON t_topics.author_id = t_users.id 
            INNER JOIN SPF_FORUMS AS t_cats 
            ON t_topics.forum_id = t_cats.id 
            WHERE forum_id = '{$forum_id}'
            LIMIT {$limit}
            OFFSET {$offset}";
        return $wpdb->get_results($query, ARRAY_A);
    }

    // Este metodo devuelve un array con todos los posts de un topic
    public static function get_posts($topic_id = 1, $limit = 0, $offset = 3) {
        global $wpdb;
        $query = "SELECT
            SPF_POSTS.post_content, 
            SPF_POSTS.posted_at, 
            SPF_ACCOUNTS.username 
            FROM SPF_POSTS 
            INNER JOIN SPF_ACCOUNTS 
            ON SPF_POSTS.author_id = SPF_ACCOUNTS.id 
            WHERE topic_id = '{$topic_id}'
            LIMIT {$limit}
            OFFSET {$offset}";

        return $wpdb->get_results($query, ARRAY_A);
    }

    public static function count_posts($topic_id) {
        global $wpdb;
        $query = "SELECT id FROM SPF_POSTS WHERE topic_id = '{$topic_id}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    public static function count_topics($forum_id) {
        global $wpdb;
        $query = "SELECT id FROM SPF_TOPICS WHERE forum_id = '{$forum_id}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
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
            t_topics.forum_id,
            t_topics.title,
            t_topics.created_at,
            t_users.username AS author,
            t_forums.name AS subforum 
            FROM SPF_TOPICS AS t_topics 
            INNER JOIN SPF_ACCOUNTS AS t_users 
            ON t_topics.author_id = t_users.id 
            INNER JOIN SPF_FORUMS AS t_forums 
            ON t_topics.forum_id = t_forums.id 
            WHERE t_topics.id = '{$topic_id}'";
        return $wpdb->get_row($query);
    }
    
    public static function get_forums() {
        global $wpdb;
        $query = "SELECT id, name, description FROM SPF_FORUMS";
        return $wpdb->get_results($query, ARRAY_A);
    }

    public static function get_forum($forum_id = 1) {
        global $wpdb;
        $query = "SELECT id, name, description 
            FROM SPF_FORUMS 
            WHERE id='{$forum_id}'";
        return $wpdb->get_row($query);
    }
}
