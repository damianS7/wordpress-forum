<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_TopicController {

    // Controlador de la vista 'topics.php'
    public static function view_topics() {
        // Si el usuario envia un formulario para crear un nuevo topic ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = SPF_TopicController::handle_forms();

            // Si se ha creado el topic redirigimos por js
            if (!empty($data['topic_url'])) {
                //return SimpleForum::redirect_to_url($data['topic_url']);
                $link = '<a href="' . $data['topic_url'] . '">Click to see your topic.</a>';
                return SimpleForum::view('blank.php', array('success_message' => $link));
            }
        }
        
        // ID del foro
        $forum_id = SimpleForum::get_query_var('spf_id');
        
        // Datos del foro
        $data['forum'] = SPF_Forum::get_forum($forum_id);
        
        // Si el foro no existe ...
        if ($data['forum'] === null) {
            // Mostramos una vista en blanco con el error.
            return SimpleForum::view('blank.php', array('error_message' => 'Unkown forum.'));
        }

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
        
        // Topics disponibles del foro
        $data['topics'] = SPF_Forum::get_topics($forum_id, $topics_per_page, $offset);
        
        // Datos de paginacion
        $data['pagination'] = SPF_Pagination::get_pagination($pages, $page);
        
        
        
        return SimpleForum::view('topics.php', $data);
    }

    // Metodo para procesar los formularios (POST)
    public static function handle_forms() {
        // Si el usuario no esta logeado no puede crear topics
        if (!SPF_AccountController::is_auth()) {
            return array('error_message' => 'Only auth users can create topics.');
        }
        
        // Si el usuario esta baneado no podra crear topics
        if (SPF_AccountController::is_banned()) {
            return array('error_message' => 'You are banned.');
        }

        // ID del foro
        $forum_id = SimpleForum::get_query_var('spf_id');
        
        // Filtrado de variables enviadas por el usuario
        $title = sanitize_text_field($_POST['topic_title']);
        $content = sanitize_text_field($_POST['post_content']);
        $user_id = $_SESSION['account']->id;
        
        // Si los campos necesarios no contienen texto
        if (empty($title) || empty($content) || empty($forum_id)) {
            return array('error_message' => 'All fields must be filled.');
        }
        // Creamos el topic
        $topic_id = SPF_Forum::create_topic($forum_id, $user_id, $title, $content);
        
        // Si el id del topic es null, es que no pudo crease
        if ($topic_id === null) {
            return array('error_message' => 'Topic cannot been created.');
        }
        
        // URL del topic creado
        return array('topic_url' => SimpleForum::pagination_url('posts', $topic_id, 1));
    }

    // Metodo para renderizar la vista.
    public static function render($data = array()) {
        return SimpleForum::view('topics.php', $data);
    }
}