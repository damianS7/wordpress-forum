<?php

// Controlador de la vista "forums.php"
class SPF_Admin_ForumsController {

    // Controlador de la vista "forums"
    public function view_forums() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->render($this->handle_forms());
        }
        
        return $this->render();
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        // Creacion de forum
        if (isset($_POST['create_forum'])) {
            $name = sanitize_text_field($_POST['name']);
            $description = sanitize_text_field($_POST['description']);
            if (SPF_Admin_Forum::create_forum($name, $description)) {
                $data['success_message'] = 'The forum has been created.';
            }
        }

        // Borrado de foro
        if (isset($_POST['delete_forum'])) {
            $forum_id = sanitize_text_field($_POST['forum_id']);
            if (SPF_Admin_Forum::delete_forum($forum_id)) {
                $data['success_message'] = 'The forum has been deleted.';
            }
        }

        return $data;
    }

    // Metodo para renderizar la vista.
    public function render($data = array()) {
        $data['forums'] = SPF_Admin_Forum::get_forums();
        return SimpleForumAdmin::view('forums.php', $data);
    }
}
