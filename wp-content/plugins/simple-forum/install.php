<?php

// Instalacion y Desinstalacion del plugin
class SimpleForumInstall {
    
    // Acciones a llevar a cabo cuando el plugin es activado
    public function plugin_activation() {
        global $wpdb;

        $query_accounts = 'CREATE TABLE IF NOT EXISTS SPF_ACCOUNTS (
            id INT AUTO_INCREMENT NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            PRIMARY KEY(id)
        ) ENGINE=InnoDB;';

        $query_forums = 'CREATE TABLE IF NOT EXISTS SPF_FORUMS (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(50) NOT NULL UNIQUE,
            description VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        ) ENGINE=InnoDB;';

        $query_topics = 'CREATE TABLE IF NOT EXISTS SPF_TOPICS (
            id INT AUTO_INCREMENT NOT NULL,
            cat_id INT NOT NULL,
            author_id INT NOT NULL,
            title VARCHAR(100) NOT NULL,
            created_at TIMESTAMP NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(cat_id) REFERENCES SPF_FORUMS(id),
            FOREIGN KEY(author_id) REFERENCES SPF_ACCOUNTS(id)
        ) ENGINE=InnoDB;';

        $query_posts = 'CREATE TABLE IF NOT EXISTS SPF_POSTS (
            id INT AUTO_INCREMENT NOT NULL,
            topic_id INT NOT NULL,
            author_id INT NOT NULL,
            post_content TEXT NOT NULL,
            posted_at TIMESTAMP NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(topic_id) REFERENCES SPF_TOPICS(id),
            FOREIGN KEY(author_id) REFERENCES SPF_ACCOUNTS(id)
        ) ENGINE=InnoDB;';

        $query_settings = 'CREATE TABLE IF NOT EXISTS SPF_SETTINGS (
            spf_key VARCHAR(50) NOT NULL UNIQUE,
            spf_value TEXT,
            PRIMARY KEY(spf_key)
        ) ENGINE=InnoDB;';

        $wpdb->query($query_accounts);
        $wpdb->query($query_forums);
        $wpdb->query($query_topics);
        $wpdb->query($query_posts);
        $wpdb->query($query_settings);
        
        $this->spf_create_pages();
    }

    // Desactivar y borrar plugin
    public function plugin_uninstall() {
    }

    // Acciones a llevar a cabo cuando el plugin es desactivado
    // (deshacer todo lo hecho en activacion)
    public function plugin_deactivation() {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS SPF_SETTINGS");
        $wpdb->query("DROP TABLE IF EXISTS SPF_POSTS");
        $wpdb->query("DROP TABLE IF EXISTS SPF_TOPICS");
        $wpdb->query("DROP TABLE IF EXISTS SPF_FORUMS");
        $wpdb->query("DROP TABLE IF EXISTS SPF_ACCOUNTS");
        $this->spf_delete_pages();
    }

    // Borra las paginas que contienen el shortcode del plugin
    public function spf_delete_pages() {
        global $wpdb;
        $wpdb->delete('wp_posts', array(
            'post_content' => '[spf_view_forums]',
        ));

        $wpdb->delete('wp_posts', array(
            'post_content' => '[spf_view_topics]',
        ));

        $wpdb->delete('wp_posts', array(
            'post_content' => '[spf_view_posts]',
        ));

        $wpdb->delete('wp_posts', array(
            'post_content' => '[spf_view_signin]',
        ));

        $wpdb->delete('wp_posts', array(
            'post_content' => '[spf_view_signup]',
        ));

        $wpdb->delete('wp_posts', array(
            'post_content' => '[spf_view_reset]',
        ));

        $wpdb->delete('wp_posts', array(
            'post_content' => '[spf_view_profile]',
        ));
    }

    // Crea las paginas que muestran las diferentes partes de la aplicacion
    // una pagina para el foro, otra para el formulario de registro etc...
    public function spf_create_pages() {
        // Create post object
        $forums_page = array(
            'post_title'   => wp_strip_all_tags('SPF FORUMS'),
            'post_content' => '[spf_view_forums]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );

        $topics_page = array(
            'post_title'   => wp_strip_all_tags('SPF TOPICS'),
            'post_content' => '[spf_view_topics]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );

        $posts_page = array(
            'post_title'   => wp_strip_all_tags('SPF POSTS'),
            'post_content' => '[spf_view_posts]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );

        $login_page = array(
            'post_title'   => wp_strip_all_tags('SPF SIGNIN'),
            'post_content' => '[spf_view_signin]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );

        $register_page = array(
            'post_title'   => wp_strip_all_tags('SPF SIGNUP'),
            'post_content' => '[spf_view_signup]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );

        $reset_page = array(
            'post_title'   => wp_strip_all_tags('SPF RESET'),
            'post_content' => '[spf_view_reset]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );

        $profile_page = array(
            'post_title'   => wp_strip_all_tags('SPF PROFILE'),
            'post_content' => '[spf_view_profile]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );

        // Insert the post into the database
        wp_insert_post($forums_page);
        wp_insert_post($topics_page);
        wp_insert_post($posts_page);
        wp_insert_post($login_page);
        wp_insert_post($register_page);
        wp_insert_post($reset_page);
        wp_insert_post($profile_page);
    }
}
