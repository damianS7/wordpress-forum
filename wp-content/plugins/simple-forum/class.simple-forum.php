<?php

class SimpleForum {

    // Acciones a llevar a cabo cuando el plugin es activado
    public function plugin_activation() {
        global $wpdb;

        
        $queryUsers = "CREATE TABLE IF NOT EXISTS SPF_USERS(
            id INT AUTO_INCREMENT NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            PRIMARY KEY(id)
        )";

        $queryCategories = "CREATE TABLE IF NOT EXISTS SPF_CATEGORIES(
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(50) NOT NULL UNIQUE,
            description VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )";
        

        $queryTopics = "CREATE TABLE IF NOT EXISTS SPF_TOPICS (
            id INT AUTO_INCREMENT NOT NULL,
            cat_id INT NOT NULL,
            author_id INT NOT NULL,
            title VARCHAR(100) NOT NULL,
            created_at TIMESTAMP NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(cat_id) REFERENCES SPF_CATEGORIES(id),
            FOREIGN KEY(author_id) REFERENCES SPF_USERS(id)
        )";

        $queryPosts = "CREATE TABLE IF NOT EXISTS SPF_POSTS (
            id INT AUTO_INCREMENT NOT NULL,
            topic_id INT NOT NULL,
            author_id INT NOT NULL,
            post_content TEXT NOT NULL,
            posted_at TIMESTAMP NOT NULL,
            PRIMARY KEY(id),
            FOREIGN KEY(topic_id) REFERENCES SPF_TOPICS(id),
            FOREIGN KEY(author_id) REFERENCES SPF_USERS(id)
        )";

        $querySettings = "CREATE TABLE IF NOT EXISTS SPF_SETTINGS(
            spf_key VARCHAR(50) NOT NULL UNIQUE,
            spf_value TEXT,
            PRIMARY KEY(spf_key)
        )";

        
        $wpdb->query($queryUsers);
        $wpdb->query($queryCategories);
        $wpdb->query($queryTopics);
        $wpdb->query($queryPosts);
        $wpdb->query($querySettings);

        //add_option( 'fmk', '' );
    }

    // Acciones a llevar a cabo cuando el plugin es desactivado (deshacer todo lo hecho en activacion)
    public function plugin_deactivation() {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS SPF_SETTINGS");
        $wpdb->query("DROP TABLE IF EXISTS SPF_USERS");
        $wpdb->query("DROP TABLE IF EXISTS SPF_POSTS");
        $wpdb->query("DROP TABLE IF EXISTS SPF_CATEGORIES");
        $wpdb->query("DROP TABLE IF EXISTS SPF_TOPICS");
        //delete_option( 'fmk' );
    }

    // Desactivar y borrar plugin
    public function plugin_uninstall() {

    }

    public function spf_have_categories() {
        global $wpdb;
        return $wpdb->get_results("SELECT id, name, description FROM SPF_CATEGORIES" , ARRAY_A);
    }

    public function spf_have_topics( $cat_id = 1 ) {
        global $wpdb;
        return $wpdb->get_results("SELECT SPF_TOPICS.id, SPF_TOPICS.title, SPF_USERS.username AS author FROM SPF_TOPICS INNER JOIN SPF_USERS ON SPF_TOPICS.author_id = SPF_USERS.id WHERE cat_id = '{$cat_id}'" , ARRAY_A);
    }

    public function spf_show_topic( $topic_id = 1 ) {
        global $wpdb;
        return $wpdb->get_results("SELECT SPF_POSTS.post_content, SPF_POSTS.posted_at, SPF_USERS.username FROM SPF_POSTS INNER JOIN SPF_USERS ON SPF_POSTS.author_id = SPF_USERS.id WHERE topic_id = '{$topic_id}'" , ARRAY_A);
    }

    // Shortcode para mostrar el foro en una pagina
    public function show_forum( $atts ) {
        include_once( PLUGIN_DIR . 'frontend/forum.php' );
    }

    public function init_hooks() {
        add_shortcode( 'forum', array($this, 'show_forum') );
    }

    public function init() {

        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');

        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');


        wp_register_style('spf_style', plugins_url( 'simple-forum/frontend/css/spf.css' ) );
        
        wp_enqueue_style('spf_style');

        $this->init_hooks();
    }
}
