<?php

// Gestiona las vistas relacionadas con cuentas de usuario sigin/signup/reset
class SPF_LoginController {

    // Controlador de la vista 'login.php'
    public static function view_login() {
        $data = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (SPF_AccountController::is_auth()) {
                $data['error_message'] = 'You are already logged.';
                return SimpleForum::view('login.php', $data);
                //return SimpleForum::redirect_js(SimpleForum::view_url('forums'));
            }

            // Filtrado de variables introducidas por el usuario
            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);

            // Los campos no pueden estar vacios
            if (empty($user) || empty($pass)) {
                $data['error_message'] = 'You must fill the fields.';
                return SimpleForum::view('login.php', $data);
            }

            // Si pasamos con exito todas las comprobaciones, iniciamos el login.
            if (SPF_AccountController::auth($user, $pass)) {
                return SimpleForum::redirect_to_view('forums');
            } else {
                $data['error_message'] = 'Invalid username/password.';
            }
        }

        return SimpleForum::view('login.php', $data);
    }
}
