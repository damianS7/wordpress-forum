<?php

class SPF_Admin_ForumController {

    // Controlador de la vista "forums"
    public function view_forums() {
        // Creacion de forum
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_forum'])) {
            $name = sanitize_text_field($_POST['name']);
            $description = sanitize_text_field($_POST['description']);
            if (SPF_Admin_Forum::create_forum($name, $description)) {
                $data['success_message'] = 'The forum has been created.';
            }
        }

        // Borrado de foro
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_forum'])) {
            $forum_id = sanitize_text_field($_POST['forum_id']);
            if (SPF_Admin_Forum::delete_forum($forum_id) !== null) {
                $data['success_message'] = 'The forum has been deleted.';
            }
        }

        $data['forums'] = SPF_Admin_Forum::get_forums();
        SimpleForumAdmin::view('forums.php', $data);
    }
}
