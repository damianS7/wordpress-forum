<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_ForumController {

    // Controlador de la vista "search.php"
    public static function view_search() {
        // Lectura de los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['search'] = sanitize_text_field($_POST['query']);
            $data['topics'] = SPF_Forum::search_topics($data['search']);
        }

        return SimpleForum::view('search.php', $data);
    }
    
    // Controlador para "forums.php"
    public static function view_forums() {
        $data['forums'] = SPF_Forum::get_forums();
        return SimpleForum::view('forums.php', $data);
    }

    // Controlador de la vista 'topics.php'
    public static function view_topics() {
        // ID del foro
        $forum_id = SimpleForum::get_query_var('spf_forum_id');

        // Si el usuario envia un formulario para crear un nuevo topic ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SPF_AccountController::is_auth()) {
                $data['error_message'] = 'Only auth users can create topics.';
                return SimpleForum::view('topics.php', $data);
            }

            // Filtrado de variables enviadas por el usuario
            $title = sanitize_text_field($_POST['topic_title']);
            $content = sanitize_text_field($_POST['post_content']);
            $user_id = $_SESSION['account']->id;

            // Si los campos necesarios contienen texto
            if (!empty($title) && !empty($content) && !empty($forum_id)) {
                // Creamos el topic
                $topic_id = SPF_Forum::create_topic($forum_id, $user_id, $title, $content);

                // Si el id del topic es null, es que no pudo crease
                if ($topic_id === null) {
                    $data['error_message'] = 'sorry topic has not been created.';
                    return SimpleForum::view('topics.php', $data);
                }

                // Redirigimos al post recien creado.
                $url = SimpleForum::view_url('topics', $topic_id);
                return SimpleForum::redirect_to_url($url);
            }
        }

        // Topics a mostrar por pagina
        $topics_per_page = 2; // get from db

        // Numero de topics del foro indicado
        $total_topics = SPF_Forum::count_topics($forum_id);

        // Paginas disponibles (redondeado hacia arriba)
        $pages = ceil($total_topics / $topics_per_page);

        // Pagina actual
        $page = SimpleForum::get_query_var('spf_pagination');
        
        // Filtrar pagina
        $page = filter_var($page, FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
                'max_range' => $pages
            ),
        ));

        // Offset o posicion desde el que leer la base datos
        $offset = ($page - 1) * $topics_per_page;

        // Datos del foro
        $data['forum'] = SPF_Forum::get_forum($forum_id);

        // Topics disponibles del foro
        $data['topics'] = SPF_Forum::get_topics($forum_id, $topics_per_page, $offset);

        // Datos de paginacion
        $data['pagination'] = SPF_ForumController::get_pagination($pages, $page);
        return SimpleForum::view('topics.php', $data);
    }

    
    // Controlador de la vista 'posts.php'
    public static function view_posts() {
        // ID del topic
        $topic_id = SimpleForum::get_query_var('spf_topic_id');
        
        // Comprobando si se ha enviado un nuevo posts
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SPF_AccountController::is_auth()) {
                $data['error_message'] = 'You are not logged.';
                return SimpleForum::view('topics.php', $data);
            }

            // ID del usuario
            $user_id = $_SESSION['account']->id;

            // Filtrado de seguridad del post enviado por el usuario
            $content = sanitize_text_field($_POST['content']);

            // Comprobamos que los campos no esten vacios
            if (!empty($topic_id) && !empty($content)) {
                // Si el post no puede ser creado ...
                if (!SPF_Forum::create_post($topic_id, $user_id, $content)) {
                    $data['error_message'] = 'Post has not been created.';
                    return SimpleForum::view('posts.php', $data);
                }
            }
        }

        // Posts por pagina
        $posts_per_page = 3; // get from db

        // Numero de posts del topic
        $total_posts = SPF_Forum::count_posts($topic_id);

        // Paginas en las que se divide el topic
        $pages = ceil($total_posts / $posts_per_page);

        // Pagina actual
        $page = SimpleForum::get_query_var('spf_pagination');

        $page = filter_var($page, FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
                'max_range' => $pages
            ),
        ));

        // Offset desde que empezamos a leer resultados de la tabla
        $offset = ($page - 1) * $posts_per_page;
        
        // Informacion del topic
        $data['topic'] = SPF_Forum::get_topic($topic_id);

        // Posts del topic
        $data['posts'] = SPF_Forum::get_posts($topic_id, $posts_per_page, $offset);

        // Datos de paginacion
        $data['pagination'] = SPF_ForumController::get_pagination($pages, $page);
        return SimpleForum::view('posts.php', $data);
    }

    // Metodo que devuelve un array con las paginas que corresponden a cada boton
    public static function get_pagination($pages, $page) {
        // Evitamos que el numero de pagina sea menor a 1
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
}
