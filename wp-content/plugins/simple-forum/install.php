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
            name VARCHAR(50) NOT NULL UNIQUE,
            value TEXT,
            PRIMARY KEY(name)
        ) ENGINE=InnoDB;';

        $wpdb->query($query_accounts);
        $wpdb->query($query_forums);
        $wpdb->query($query_topics);
        $wpdb->query($query_posts);
        $wpdb->query($query_settings);
        
        // Preparamos la pagina para cargar nuestro plugin
        $shortcode_page = array(
            'post_title'   => wp_strip_all_tags('SPF FORUM'),
            'post_content' => '[spf_forum]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page',
        );
        
        // Creamos la pagina donde se inserta el shortcode del plugin
        $id = wp_insert_post($shortcode_page);

        // Si el $id no es null, sera un numero que contiene el id del post en la db
        if ($id !== null) {
            $data = array(
                'name' => 'plugin_page_id',
                'value' => $id
            );
            // Guardamos el id en las opciones del plugin
            $wpdb->insert('SPF_SETTINGS', $data, array('%s', '%s'));
        }
    }

    // Desactivar y borrar plugin
    public function plugin_uninstall() {
    }

    // Acciones a llevar a cabo cuando el plugin es desactivado
    // (deshacer todo lo hecho en activacion)
    public function plugin_deactivation() {
        global $wpdb;
        $wpdb->query('DROP TABLE IF EXISTS SPF_SETTINGS');
        $wpdb->query('DROP TABLE IF EXISTS SPF_POSTS');
        $wpdb->query('DROP TABLE IF EXISTS SPF_TOPICS');
        $wpdb->query('DROP TABLE IF EXISTS SPF_FORUMS');
        $wpdb->query('DROP TABLE IF EXISTS SPF_ACCOUNTS');

        // Borra las paginas que contienen el shortcode del plugin
        $wpdb->delete('wp_posts', array(
            'post_title' => 'SPF FORUM',
        ));
    }
}
