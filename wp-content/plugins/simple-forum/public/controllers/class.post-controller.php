<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_PostController {

    // Controlador de la vista 'posts.php'
    public static function view_posts() {
        // ID del topic
        $topic_id = SimpleForum::get_query_var('spf_id');
        
        // Posts por pagina
        $posts_per_page = SimpleForum::get_setting('posts_per_page'); // get from db
        
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
                            'max_range' => $pages)
        ));
        
        // Offset desde que empezamos a leer resultados de la tabla
        $offset = ($page - 1) * $posts_per_page;
                
        // Informacion del topic
        $data['topic'] = SPF_Forum::get_topic($topic_id);
        
        // Posts del topic
        $data['posts'] = SPF_Forum::get_posts($topic_id, $posts_per_page, $offset);
        
        // Datos de paginacion
        $data['pagination'] = SPF_ForumController::get_pagination($pages, $page);

        // Comprobando si se ha enviado un nuevo posts
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SPF_AccountController::is_auth()) {
                $data['error_message'] = 'You are not logged.';
                return SimpleForum::view('posts.php', $data);
            }

            if (SPF_AccountController::is_banned()) {
                $data['error_message'] = 'You are banned.';
                return SimpleForum::view('posts.php', $data);
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

        return SimpleForum::view('posts.php', $data);
    }
}
