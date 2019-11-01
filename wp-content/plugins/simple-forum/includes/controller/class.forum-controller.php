<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_ForumController {
    public static function forums_controller() {
        $data['forums'] = SPF_Forum::get_forums();
        return SimpleForum::view('forums.php', $data);
    }

    // Controlador de la vista "topics.php"
    public static function topics_controller() {
        $forum_id = SimpleForum::get_query_var('spf_forum_id');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SPF_AccountController::is_auth()) {
                $data['error_message'] = "You are not logged.";
                return SimpleForum::view('topics.php', $data);
            }

            $title = sanitize_text_field($_POST['topic_title']);
            $content = sanitize_text_field($_POST['post_content']);
            $user_id = $_SESSION['account']->id;

            if (!empty($title) && !empty($content) && !empty($user_id) && !empty($forum_id)) {
                $topic_id = SPF_Forum::create_topic($forum_id, $user_id, $title, $content);

                if ($topic_id !== null) {
                    return SimpleForum::redirect_js('posts/' . $topic_id);
                }

                $data['error_message'] = "sorry topic has not been created.";
            }
        }

        $posts_per_page = 2; // get from db
        $total_posts = SPF_Forum::count_topics($forum_id);
        $pages = ceil($total_posts / $posts_per_page);

        $page = SimpleForum::get_query_var('spf_pagination');

        $page = filter_var($page, FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
                'max_range' => $pages
            ),
        ));

        $offset = ($page - 1) * $posts_per_page;

        $data['forum'] = SPF_Forum::get_forum($forum_id);
        $data['topics'] = SPF_Forum::get_topics($forum_id, $posts_per_page, $offset);
        $data['pagination'] = SPF_ForumController::get_pagination($pages, $page);
        return SimpleForum::view('topics.php', $data);
    }

    
    // Controlador de la vista "posts.php"
    public static function posts_controller() {
        $topic_id = SimpleForum::get_query_var('spf_topic_id');
        
        // Comprobando si se ha enviado un nuevo posts
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SPF_AccountController::is_auth()) {
                $data['error_message'] = "You are not logged.";
                return SimpleForum::view('topics.php', $data);
            }

            $user_id = $_SESSION['account']->id;
            $content = sanitize_text_field($_POST['content']);

            if (!empty($topic_id) && !empty($content) && !empty($user_id)) {
                if (!SPF_Forum::add_post($topic_id, $user_id, $content)) {
                    $data['error_message'] = "sorry post shas not been created." . $topic_id;
                }
            }
        }

        
        $posts_per_page = 3; // get from db
        $total_posts = SPF_Forum::count_posts($topic_id);
        $pages = ceil($total_posts / $posts_per_page);

        $page = SimpleForum::get_query_var('spf_pagination');

        $page = filter_var($page, FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
                'max_range' => $pages
            ),
        ));

        $offset = ($page - 1) * $posts_per_page;
        
        // Comprobacion de que pagina (id) se ha requerido
        $data['topic'] = SPF_Forum::get_topic($topic_id);
        $data['posts'] = SPF_Forum::get_posts($topic_id, $posts_per_page, $offset);
        $data['pagination'] = SPF_ForumController::get_pagination($pages, $page);
        return SimpleForum::view('posts.php', $data);
    }

    public static function get_pagination($pages, $page) {
        $prev = filter_var(($page-1), FILTER_VALIDATE_INT, array(
            'options' => array(
            'default' => 1,
            'min_range' => 1,
            'max_range' => $pages),
        ));

        return array('first' => 1,
            'last' => $pages,
            'prev' => $prev,
            'next' => ($page+1),
            'actual' => $page,
            'pages' => $pages
        );
    }

    public static function get_pagination_number() {
    }
}
