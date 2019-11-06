<?php

// Controlador de la vista "search.php"
class SPF_SearchController {
    
    // Metodo que controla la logica principal de la vista
    public static function view_search() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return SPF_SearchController::render(SPF_SearchController::handle_forms());
        }
        
        return SPF_SearchController::render();
    }

    // Metodo para procesar los formularios (POST)
    public static function handle_forms() {
        $data['search'] = sanitize_text_field($_POST['query']);
        $data['topics'] = SPF_Forum::search_topics($data['search']);
        return $data;
    }

    // Metodo para renderizar la vista.
    public static function render($data = array()) {
        return SimpleForum::view('search.php', $data);
    }
}