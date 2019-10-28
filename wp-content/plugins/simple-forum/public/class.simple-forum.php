<?php
require_once(PLUGIN_DIR . 'includes/class-simple-forum-auth.php');
require_once(PLUGIN_DIR . 'includes/class-simple-forum-account.php');
require_once(PLUGIN_DIR . 'includes/class-simple-forum-topic.php');
require_once(PLUGIN_DIR . 'includes/class-simple-forum-subforum.php');

// Front-end
class SimpleForum {

    // Muestra una vista
    public function spf_view($view, $data = '') {
        $data['user'] = array('id' => 1, 'username' => 'damianS7');
        include_once(PLUGIN_DIR . $view);
    }

    // Controlador de la vista profile
    public function spf_view_profile() {
        return $this->spf_view('public/views/profile.php', $data);
    }

    // Controlador de la vista "forums.php"
    public function spf_view_forums($atts) {
        $data['forums'] = SimpleForumSubForum::get_forums();
        return $this->spf_view('public/views/forums.php', $data);
    }

    // Controlador de la vista "topics.php"
    public function spf_view_topics($atts) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SimpleForumAuth::is_auth()) {
                $data['error_message'] = "You are not logged.";
                return $this->spf_view('public/views/topics.php', $data);
            }

            $title = sanitize_text_field($_POST['topic_title']);
            $content = sanitize_text_field($_POST['post_content']);
            $user_id = $_SESSION['account']->id;
            $forum_id = sanitize_text_field($_POST['forum_id']);

            if (!empty($title) && !empty($content) && !empty($user_id) && !empty($forum_id)) {
                $topic_id = SimpleForumTopic::create_topic($forum_id, $user_id, $title, $content);

                if ($topic_id !== null) {
                    return $this->spf_redirect_js(home_url() . '/spf-show-post/' . $topic_id);
                }

                $data['error_message'] = "sorry topic has not been created.";
            }
        }

        $forum_id = $this->spf_get_id_from_url();
        $data['forum'] = SimpleForumSubForum::get_forum($forum_id);
        $data['topics'] = SimpleForumSubForum::get_topics($forum_id);
        return $this->spf_view('public/views/topics.php', $data);
    }
    
    // Controlador de la vista "posts.php"
    public function spf_view_posts($atts) {
        
        // Comprobando si se ha enviado un nuevo posts
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SimpleForumAuth::is_auth()) {
                $data['error_message'] = "You are not logged.";
                return $this->spf_view('public/views/topics.php', $data);
            }

            $topic_id = sanitize_text_field($_POST['topic_title']);
            $user_id = sanitize_text_field($_POST['user_id']);
            $content = sanitize_text_field($_POST['forum_id']);

            if (!empty($topic_id) && !empty($content) && !empty($user_id)) {
                if (!SimpleForumTopic::add_post($topic_id, $user_id, $content)) {
                }
            }
        }
        
        // Comprobacion de que pagina (id) se ha requerido
        $topic_id = $this->spf_get_id_from_url();
        $data['topic'] = SimpleForumTopic::get_topic($topic_id);
        $data['posts'] = SimpleForumTopic::get_posts($topic_id);
        return $this->spf_view('public/views/posts.php', $data);
    }

    // Controlador de la vista "login.php"
    public function spf_view_login($atts) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (SimpleForumAuth::is_auth()) {
                $data['error_message'] = "You are already logged.";
                return $this->spf_view('public/views/login.php', $data);
            }

            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);

            if (empty($user) || empty($pass)) {
                $data['error_message'] = "You must fill the fields.";
                return $this->spf_view('public/views/login.php', $data);
            }

            if (SimpleForumAuth::auth($user, $pass)) {
                return $this->spf_redirect_js(home_url() . '/spf-show-forums');
            } else {
                $data['error_message'] = "Invalid username/password.";
            }
        }
        
        return $this->spf_view('public/views/login.php', $data);
    }

    // Controlador de la vista "register.php"
    public function spf_view_register($atts) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);
            $mail = sanitize_email($_POST['email']);

            if (!SimpleForumAccount::create_account($user, $pass, $mail)) {
                $data['error_message'] = "Error al crear la cuenta.";
                return $this->spf_view('public/views/register.php', $data);
            }
            $data['success_message'] = "Cuenta creada con exito.";
        }
        return $this->spf_view('public/views/register.php', $data);
    }
    // ---------------------------
    // ---------------------------

    // Forma segura de obtener valores de $_GET
    public function get_query_var($var, $default = '') {
        global $wp_query;
        return $wp_query->get($var, $default);
    }

    // La variable page es la que contiene el id usado en la url para leer el foro
    public function spf_get_id_from_url() {
        if (get_query_var('page') == 0) {
            set_query_var('page', 1);
        }
        return get_query_var('page');
    }
 
    public function get_current_url() {
        global $wp;
        return add_query_arg($wp->query_vars, home_url($wp->request));
    }

    public function spf_redirect_js($url) {
        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';
        echo $string;
    }
                        
    // Comprueba si el mod esta habilitado, si no lo esta el plugin no funcionara
    public function check_rewrite_enabled() {
        // avisar de que se necesita rewrite?
        // return
    }
    
    public function spf_start_session() {
        @session_start();
    }

    public function spf_check_logout_request() {
        if (strpos($_SERVER['REQUEST_URI'], 'spf-logout') !== false) {
            if (SimpleForumAuth::is_auth()) {
                SimpleForumAuth::logout();
                wp_redirect(home_url() . '/spf-show-login');
                exit;
            }
        }
    }

    public function spf_check_forbbiden_for_auth() {
        // Si estamos en la pagina de login
        //global $wp;
        //echo home_url($wp->request);
        if (strpos($_SERVER['REQUEST_URI'], 'spf-show-login') !== false) {
            // y estamos logeados, se hace redirect
            if (SimpleForumAuth::is_auth()) {
                wp_redirect(home_url() . '/spf-show-forums');
                exit;
            }
        }
    }
        
    public function init_hooks() {
        $this->spf_start_session();
        $this->spf_check_forbbiden_for_auth();
        $this->spf_check_logout_request();
        //add_action('spf_login_redirect', array( $this, 'spf_new_topic_redirect' ));
        add_shortcode('spf_profile', array($this, 'spf_view_profile'));
        add_shortcode('spf_show_forums', array($this, 'spf_view_forums'));
        add_shortcode('spf_show_topics', array($this, 'spf_view_topics'));
        add_shortcode('spf_show_posts', array($this, 'spf_view_posts'));
        add_shortcode('spf_show_login', array($this, 'spf_view_login'));
        add_shortcode('spf_show_register', array($this, 'spf_view_register'));
    }
    
    public function init() {
        $this->init_hooks();
        // if session set to sucess topic creation redirect to topic
        //enqueue font
        wp_register_script('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
        wp_enqueue_script('prefix_bootstrap');
        wp_register_style('prefix_bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
        wp_enqueue_style('prefix_bootstrap');
        wp_register_style('spf_style', plugins_url('simple-forum/public/css/spf.css'));
        //wp_enqueue_style('spf_style');
    }
}
