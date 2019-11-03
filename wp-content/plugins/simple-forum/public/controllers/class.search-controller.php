<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_SearchController {

    // Controlador de la vista "search.php"
    public static function view_search() {
        // Lectura de los datos enviados por el usuario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['search'] = sanitize_text_field($_POST['query']);
            $data['topics'] = SPF_Forum::search_topics($data['search']);
        }

        return SimpleForum::view('search.php', $data);
    }
}
