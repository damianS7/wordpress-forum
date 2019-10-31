<?php
require_once(PLUGIN_DIR . 'includes/controller/class.account-controller.php');
require_once(PLUGIN_DIR . 'includes/controller/class.forum-controller.php');
require_once(PLUGIN_DIR . 'includes/model/class.account-model.php');
require_once(PLUGIN_DIR . 'includes/model/class.forum-model.php');

// Front-end
class SimpleForum {

    // Este metodo llama al controlador correspodiente para la pagina indicada.
    public function view_controller() {
        // La pagina se obtiene del parametro "spf_view" de la URL
        $page = get_query_var('spf_view');
        
        // Evalua la variable y llamar a la vista correspondiente
        switch ($page) {
            case "forums":
                return SPF_ForumController::forums_controller();
            case "topics":
                return SPF_ForumController::topics_controller();
            case "posts":
                return SPF_ForumController::posts_controller();
            case "login":
                return SPF_AccountController::login_controller();
            case "register":
                return SPF_AccountController::register_controller();
            case "reset":
                return SPF_AccountController::reset_controller();
            case "profile":
                return SPF_AccountController::profile_controller();
            case "logout":
                return SPF_AccountController::logout_controller();
            default: // Vista por defecto si no se escoge una valida
                return SPF_ForumController::forums_controller();
        }
    }

    // Muestra una vista
    public static function view($view, $data) {
        if (SPF_AccountController::is_auth()) {
            $data['user'] = $_SESSION['account'];
        }
        include_once(PLUGIN_DIR . 'public/views/' . $view);
    }
    
    // Forma segura de obtener valores de $_GET
    public static function get_query_var($var, $default = 1) {
        global $wp_query;
        return $wp_query->get($var, $default);
    }

    // Redirecion usando js
    public static function redirect_js($view) {
        $url = home_url() . '/spf-forum/' . $view;
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';
        echo $string;
    }
    
    public function start_session() {
        @session_start();
    }

    public function check_forbbiden_for_auth() {
        // Si estamos en la pagina de login
        if (strpos($_SERVER['REQUEST_URI'], 'spf-forum/login') !== false) {
            // y estamos logeados, se hace redirect
            if (SPF_AccountController::is_auth()) {
                wp_redirect(home_url() . '/spf-forum/forums');
                exit;
            }
        }
    }

    public function init_hooks() {
        // TODO LIST
        // PAGINACION
        // MEJORA DE LA UI
        // PROFILE
        // BUSCAR POSTS
        // CONFIGURACION DESDE PANEL AdmiNISTRADOR
        $this->start_session();
        $this->check_forbbiden_for_auth();
        // add_action('spf_login_redirect', array( $this, 'spf_new_topic_redirect' ));
        add_shortcode('spf_forum', array($this, 'view_controller'));
    }
    
    public function init() {
        $this->init_hooks();
        //enqueue font
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
        wp_register_style('spf_style', plugins_url('simple-forum/public/css/spf.css'));
        //wp_enqueue_style('spf_style');
    }
}
