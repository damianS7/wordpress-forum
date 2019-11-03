<?php

// Gestiona las vistas relacionadas con el foro. listado de foros/topics/posts
class SPF_ForumController {

    // Controlador para "forums.php"
    public static function view_forums() {
        $data['forums'] = SPF_Forum::get_forums();
        return SimpleForum::view('forums.php', $data);
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
