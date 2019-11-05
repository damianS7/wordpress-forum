<?php

require_once(PLUGIN_DIR . 'public/controllers/class.account-controller.php');
require_once(PLUGIN_DIR . 'public/controllers/class.report-controller.php');
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
require_once(PLUGIN_DIR . 'public/models/class.report-model.php');


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
            case 'report':
                return SPF_ReportController::view_report();
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
            $id = SimpleForum::get_query_var('spf_id');
        }

        if ($view == 'posts' && empty($id)) {
            $id = SimpleForum::get_query_var('spf_id');
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

    public function add_custom_query_var($vars) {
        $vars[] = 'spf_pagination';
        $vars[] = 'spf_id';
        $vars[] = 'spf_view';
        return $vars;
    }

    public function rewrite_rules() {
        $plugin_page_id = SimpleForum::get_setting('plugin_page_id');
        add_rewrite_rule(
            '^spf-forum/([^/]*)/([^/]*)/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=$matches[1]&spf_id=$matches[2]&spf_pagination=$matches[3]',
            'top'
        );

        add_rewrite_rule(
            '^spf-forum/([^/]*)/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=$matches[1]&spf_id=$matches[2]',
            'top'
        );

        add_rewrite_rule(
            '^spf-forum/([^/]*)/?',
            'index.php?page_id=' . $plugin_page_id . '&spf_view=$matches[1]',
            'top'
        );
        flush_rewrite_rules();
    }

    public function init() {
        add_action('init', array( $this, 'rewrite_rules' ), 9999);
        add_filter('query_vars', array( $this, 'add_custom_query_var'));
        add_shortcode('spf_forum', array($this, 'view_controller'));
        $this->start_session();
        
        // jQuery
        wp_enqueue_style('wpb-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300', false);
        wp_register_script('prefix_jquery', 'https://code.jquery.com/jquery-3.4.1.min.js');
        wp_enqueue_script('prefix_jquery');
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
        wp_register_style('spf_style', plugins_url('simple-forum/public/includes/css/spf.css'));
        wp_enqueue_style('spf_style');
    }
}
