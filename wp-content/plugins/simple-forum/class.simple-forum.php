<?php

// Front-end
class SimpleForum {
    
    // Forma segura de obtener valores de $_GET
    public function get_query_var( $var, $default = '' ) {
        global $wp_query;
        return $wp_query->get( $var, $default );
    }
 
    public function get_current_url() {
        global $wp;
        return add_query_arg( $wp->query_vars, home_url( $wp->request ));

    }
                        
    public function spf_get_forums() {
        global $wpdb;
        return $wpdb->get_results("SELECT id, name, description FROM SPF_CATEGORIES", ARRAY_A);
    }
                        
    public function spf_get_topics($cat_id = 1) {
        global $wpdb;
        return $wpdb->get_results("SELECT t_topics.id, t_topics.title, t_topics.created_at, t_users.username AS author, t_cats.name AS subforum, (SELECT count(*) FROM SPF_POSTS WHERE SPF_POSTS.topic_id=t_topics.id) AS total_posts FROM SPF_TOPICS AS t_topics INNER JOIN SPF_USERS AS t_users ON t_topics.author_id = t_users.id INNER JOIN SPF_CATEGORIES AS t_cats ON t_topics.cat_id = t_cats.id WHERE cat_id = '{$cat_id}'", ARRAY_A);
    }

    
                        
    public function spf_get_topic($topic_id = 1) {
        global $wpdb;
        return $wpdb->get_results("SELECT SPF_POSTS.post_content, SPF_POSTS.posted_at, SPF_USERS.username FROM SPF_POSTS INNER JOIN SPF_USERS ON SPF_POSTS.author_id = SPF_USERS.id WHERE topic_id = '{$topic_id}'", ARRAY_A);
    }

    // Agrega un nuevo post a un topic ya iniciado
    public function spf_create_post($topic_id, $author_id, $content) {
        global $wpdb;
        return $wpdb->insert('SPF_POSTS',
            array(
                'topic_id' => $topic_id, 
                'author_id' => $author_id,
                'post_content' => $content
            ),
            array('%d', '%d','%s')
        );
    }

    // Agrega un nuevo topic a una categoria
    public function spf_create_topic($cat_id, $author_id, $title, $content) {
        global $wpdb;
        $wpdb->insert('SPF_TOPICS',
            array(
                'cat_id' => $cat_id, 
                'author_id' => $author_id,
                'title' => $title
            ),
            array('%d', '%d','%s')
        );
        $topic_id = $wpdb->insert_id;
        return $this->spf_create_post($topic_id, $author_id, $content);
    }

    public function spf_create_user($username, $password, $email) {
        global $wpdb;
        return $wpdb->insert('SPF_USERS',
            array(
                'username' => $username, 
                'password' => $password,
                'email' => $email
            ),
            array('%s', '%s','%s')
        );
    }

    public function spf_login_user($username, $password) {

    }
                        
    // Shortcode para mostrar el foro en una pagina
    public function spf_show_forums($atts) {
        include_once(PLUGIN_DIR . 'include/forums.php');
    }

    public function spf_show_topics($atts) {
        include_once(PLUGIN_DIR . 'include/topics.php');
    }

    public function spf_show_posts($atts) {
        include_once(PLUGIN_DIR . 'include/posts.php');
    }

    public function spf_show_login($atts) {
        include_once(PLUGIN_DIR . 'include/login.php');
    }

    public function spf_show_register($atts) {
        include_once(PLUGIN_DIR . 'include/register.php');
    }

    // Comprueba si el mod esta habilitado, si no lo esta el plugin no funcionara
    public function check_rewrite_enabled() {
        // return
    }

    public function choose_font() {
        //enqueue font
    }
        
    public function init_hooks() {
        add_shortcode('spf_show_forums', array($this, 'spf_show_forums'));
        add_shortcode('spf_show_topics', array($this, 'spf_show_topics'));
        add_shortcode('spf_show_posts', array($this, 'spf_show_posts'));
        add_shortcode('spf_show_login', array($this, 'spf_show_login'));
        add_shortcode('spf_show_register', array($this, 'spf_show_register'));
    }
                        
    public function init() {
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');        
        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
        wp_register_style('spf_style', plugins_url('simple-forum/include/css/spf.css'));
        //wp_enqueue_style('spf_style');
        $this->init_hooks();
    }
}