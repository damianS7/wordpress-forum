<?php

require_once(PLUGIN_DIR . 'public/controllers/class.account-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.profile-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.register-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.search-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.post-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.topic-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.reset-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.login-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.logout-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.forum-controller.php');
require_once(PLUGIN_DIR . 'public/models/class.account-model.php');
require_once(PLUGIN_DIR . 'public/models/class.forum-model.php');


// Front-end
class SimpleForum {
    public function __construct() {
    }
 
    // Este metodo llama al controlador correspodiente para la pagina indicada.
    public function view_controller() {
        // La pagina se obtiene del parametro 'spf_view' de la URL
        $page = get_query_var('spf_view');
        
        // Evalua la variable y llamar a la vista correspondiente
        switch ($page) {
            case 'forums':
                return SPF_ForumController::view_forums();
            case 'topics':
                return SPF_TopicController::view_topics();
            case 'posts':
                return SPF_PostController::view_posts();
            case 'login':
                return SPF_LoginController::view_login();
            case 'register':
                return SPF_RegisterController::view_register();
            case 'reset':
                return SPF_ResetController::view_reset();
            case 'profile':
                return SPF_ProfileController::view_profile();
            case 'search':
                return SPF_SearchController::view_search();
            case 'logout':
                return SPF_LogoutController::view_logout();
            default: // Vista por defecto si no se escoge una valida
                return SPF_ForumController::view_forums();
        }
    }

    // Muestra una vista
    public static function view($view, $data) {
        if (SPF_AccountController::is_auth()) {
            $data['user'] = $_SESSION['account'];
        }
        include_once(PLUGIN_DIR . 'public/views/template.php');
    }
    
    // Forma segura de obtener valores de $_GET
    public static function get_query_var($var, $default = 1) {
        global $wp_query;
        return $wp_query->get($var, $default);
    }

    // Redirecion usando js
    public static function redirect_to_view($view) {
        $url = SimpleForum::view_url($view);
        return SimpleForum::redirect_to_url($url);
    }

    // Redirecion usando js
    public static function redirect_to_url($url) {
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';
        echo $string;
    }
    
    // Inicia la session
    public function start_session() {
        @session_start();
    }

    // Obtiene informacion de la tabla SPF_SETTINGS
    public static function get_setting($name) {
        global $wpdb;
        $query = "SELECT value FROM SPF_SETTINGS WHERE name = '{$name}'";

        return $wpdb->get_row($query)->value;
    }

    // Metodo que devuelve la url completa de una vista incluyendo el id
    public static function view_url($view, $id = '') {
        // Si no se especifica la vista, se lee desde la url
        if (empty($view)) {
            $view = SimpleForum::get_query_var('spf_view');
        }

        // Si la vista es topics y no se especifica el ID, se extrae de la url
        if ($view == 'topics' && empty($id)) {
            $id = SimpleForum::get_query_var('spf_forum_id');
        }

        // Si la vista es posts y no se especifica el id, se extrae de la url
        if ($view == 'posts' && empty($id)) {
            $id = SimpleForum::get_query_var('spf_topic_id');
        }

        // Construccion de la url
        return get_permalink() . $view . '/' . $id;
    }
    
    // Metodo que genera una URL apta para el paginador
    public static function pagination_url($view, $id, $page) {
        $view_url = SimpleForum::view_url($view, $id);
    
        // Si no se indica una pagina, la pagina por defecto sera la de la url
        if (empty($page)) {
            $page = SimpleForum::get_query_var('spf_pagination');
        }
        
        return $view_url . '/' . $page;
    }

    public function check_forbbiden_for_auth() {
        // Si estamos en la pagina de login
        if (strpos($_SERVER['REQUEST_URI'], 'spf-forum/login') !== false) {
            // y estamos logeados, se hace redirect
            if (SPF_AccountController::is_auth()) {
                wp_redirect(SimpleForum::view_url('forums'));
                exit;
            }
        }
    }

    public function add_custom_query_var($vars) {
        $vars[] = 'spf_forum_id';
        $vars[] = 'spf_topic_id';
        $vars[] = 'spf_pagination';
        $vars[] = 'spf_view';
        return $vars;
    }

    public function custom_rewrite_basic() {
        // ID del post donde se encuentra nuestro shortcode
        $plugin_page_id = SimpleForum::get_setting('plugin_page_id');
    
        // Listado de 'topics' de un foro
        // 'example.com/wordpress/spf-forum/topics/{forum_id}/{pagination}'
        add_rewrite_rule(
            '^spf-forum/topics/([^/]*)/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=topics&spf_forum_id=$matches[1]&spf_pagination=$matches[2]',
            'top'
        );

        // 'example.com/wordpress/spf-forum/topics/{forum_id}/1'
        add_rewrite_rule(
            '^spf-forum/topics/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=topics&spf_forum_id=$matches[1]&spf_pagination=1',
            'top'
        );

        // Listado de 'posts' de un topic
        // 'example.com/wordpress/spf-forum/posts/{topic_id}/{pagination}'
        add_rewrite_rule(
            '^spf-forum/posts/([^/]*)/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=posts&spf_topic_id=$matches[1]&spf_pagination=$matches[2]',
            'top'
        );

        // Listado de 'posts' de un topic con la pagina 1 por defecto
        // 'example.com/wordpress/spf-forum/posts/{topic_id}'
        add_rewrite_rule(
            '^spf-forum/posts/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=posts&spf_topic_id=$matches[1]&spf_pagination=1',
            'top'
        );

        // Muestra la vista indicada en 'spf_view'
        // 'example.com/spf-forum/{vista}'
        add_rewrite_rule(
            '^spf-forum/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=$matches[1]',
            'top'
        );
    
        // Vista principal por defecto 'forums'
        // 'example.com/wordpress/spf-forum/' -> 'example.com/wordpress/spf-forum/forums'
        add_rewrite_rule(
            '^spf-forum/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=forums',
            'top'
        );

        flush_rewrite_rules();
    }

    public function init_hooks() {
        $this->start_session();
        add_shortcode('spf_forum', array($this, 'view_controller'));
        add_filter('query_vars', array( $this, 'add_custom_query_var'));
        add_action('init', array( $this, 'custom_rewrite_basic' ));
        $this->check_forbbiden_for_auth();

        wp_enqueue_style('wpb-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300', false);
        
        // jQuery
        wp_register_script('prefix_jquery', 'https://code.jquery.com/jquery-3.4.1.min.js');
        wp_enqueue_script('prefix_jquery');

        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
        
        wp_register_style('spf_style', plugins_url('simple-forum/public/includes/css/spf.css'));
        wp_enqueue_style('spf_style');

        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
    }
}
