<?php

// Controlador para "forums.php"
class SPF_ForumController {
    public static function view_forums() {
        // Si el usuario envia datos para actualizar su cuenta ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return SPF_ForumController::render(SPF_ForumController::handle_forms());
        }
        
        return SPF_ForumController::render();
    }

    // Metodo para procesar los formularios (POST)
    public static function handle_forms() {
    }

    // Metodo para renderizar la vista.
    public static function render($data = array()) {
        $data['forums'] = SPF_Forum::get_forums();
        return SimpleForum::view('forums.php', $data);
    }
}