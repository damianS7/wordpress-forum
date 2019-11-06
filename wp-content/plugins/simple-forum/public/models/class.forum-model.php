<?php

// Clase que permite extraer informacion relativa al foro de la base de datos.
class SPF_Forum {

    // Este metodo agrega un nuevo topic al foro
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

        // Recuperamos el ID del topic creado
        $topic_id = $wpdb->insert_id;

        // Creamos el post y recuperamos el id
        $post_id = SPF_Forum::create_post($topic_id, $author_id, $content);

        // Si el id del post es null hubo un error y no se inserto.
        if ($post_id === null) {
            return null;
        }
        
        // Insertado con exito el topic y el post. Devolvemos el id del topic
        return $topic_id;
    }

    // Metodo para recuperar los topics de un determinado foro
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
        return $wpdb->get_results($query);
    }

    // Este metodo devuelve un array con todos los posts de un topic
    public static function get_posts($topic_id = 1, $limit = 0, $offset = 3) {
        global $wpdb;
        $query = "SELECT
            SPF_POSTS.id,
            SPF_POSTS.post_content, 
            SPF_POSTS.posted_at, 
            SPF_ACCOUNTS.username,
            SPF_ACCOUNTS.banned 
            FROM SPF_POSTS 
            INNER JOIN SPF_ACCOUNTS 
            ON SPF_POSTS.author_id = SPF_ACCOUNTS.id 
            WHERE topic_id = '{$topic_id}'
            LIMIT {$limit}
            OFFSET {$offset}";

        return $wpdb->get_results($query);
    }

    // Metodo para contar los posts de un topic
    public static function count_posts($topic_id) {
        global $wpdb;
        $query = "SELECT id FROM SPF_POSTS WHERE topic_id = '{$topic_id}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    // Metodo para contar los topics de un foro
    public static function count_topics($forum_id) {
        global $wpdb;
        $query = "SELECT id FROM SPF_TOPICS WHERE forum_id = '{$forum_id}'";
        $wpdb->get_results($query);
        return $wpdb->num_rows;
    }

    // Agrega un nuevo post a un topic ya iniciado
    public static function create_post($topic_id, $author_id, $content) {
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

    // Metodo que devuelve los datos de un topic
    public static function get_topic($topic_id = 1) {
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
    
    // Metodo para obtener todos los foros disponibles
    public static function get_forums() {
        global $wpdb;
        $query = "SELECT id, name, description FROM SPF_FORUMS";
        return $wpdb->get_results($query);
    }

    // Metodo para obtener un foro de terminado
    public static function get_forum($forum_id = 1) {
        global $wpdb;
        $query = "SELECT id, name, description 
            FROM SPF_FORUMS 
            WHERE id='{$forum_id}'";
        return $wpdb->get_row($query);
    }

    // Metodo para obtener los topics en funcion de lo que el usuario busca
    public static function search_topics($query) {
        global $wpdb;
        $query = "SELECT
            t_topics.id,
            t_topics.forum_id,
            t_topics.title,
            t_topics.created_at,
            t_users.username AS author,
            t_posts.post_content AS content
            FROM SPF_TOPICS AS t_topics 
            INNER JOIN SPF_ACCOUNTS AS t_users 
            ON t_topics.author_id = t_users.id 
            INNER JOIN SPF_POSTS AS t_posts
            ON t_topics.id = t_posts.topic_id 
            WHERE t_topics.title LIKE '%{$query}%' GROUP BY t_topics.id";
        return $wpdb->get_results($query);
    }
}
