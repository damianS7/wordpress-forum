<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_TopicController {

    // Controlador de la vista 'topics.php'
    public static function view_topics() {
        // ID del foro
        $forum_id = SimpleForum::get_query_var('spf_forum_id');
        
        // Topics a mostrar por pagina
        $topics_per_page = SimpleForum::get_setting('topics_per_page'); // get from db
        
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
        
        // Si el usuario envia un formulario para crear un nuevo topic ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (!SPF_AccountController::is_auth()) {
                $data['error_message'] = 'Only auth users can create topics.';
                return SimpleForum::view('topics.php', $data);
            }
        
            // Si el usuario esta baneado no podra crear topics
            if (SPF_AccountController::is_banned()) {
                $data['error_message'] = 'Your account is banned.';
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
                $url = SimpleForum::pagination_url('posts', $topic_id, 1);
                return SimpleForum::redirect_to_url($url);
            }
        }
        
        return SimpleForum::view('topics.php', $data);
    }
}
