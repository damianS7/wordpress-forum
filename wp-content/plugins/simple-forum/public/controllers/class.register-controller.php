<?php

// Controlador para la vista "register.php"
class SPF_RegisterController {
    public static function view_register() {
        // Si el usuario esta auth ...
        if (SPF_AccountController::is_auth()) {
            $data['error_message'] = 'You are already registered and logged.';
            return SimpleForum::view('blank.php', $data);
        }

        // Si el usuario envia datos para actualizar su cuenta ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return SPF_RegisterController::render(SPF_RegisterController::handle_forms());
        }
        
        return SPF_RegisterController::render();
    }

    // Metodo para procesar los formularios (POST)
    public static function handle_forms() {

        // Filtrado de seguridad para los datos enviados por el usuario
        $user = sanitize_text_field($_POST['username']);
        $pass = sanitize_text_field($_POST['password']);
        $pass2 = sanitize_text_field($_POST['password2']);
        $mail = sanitize_email($_POST['email']);

        // Ningun campo puede estar vacio
        if (empty($user) || empty($pass) || empty($pass2) || empty($mail)) {
            $data['error_message'] = 'All fields must be filled.';
            return $data;
        }

        // Comprobamos que el usuario no exista
        if (SPF_Account::username_exists($user)) {
            $data['error_message'] = 'This username is already in use.';
            return $data;
        }
            
        // Comprobamos que el correo no exista
        if (SPF_Account::mail_exists($mail)) {
            $data['error_message'] = 'This email is already in use.';
            return $data;
        }
            
        // Comprobamos que las passwords coincidan
        if ($pass !== $pass2) {
            $data['error_message'] = 'Passwords does not match.';
            return $data;
        }

        // Todas las comprobaciones realizadas con exito, encriptamos el password
        $pass = password_hash($pass, PASSWORD_BCRYPT, array( 'cost' => 12 ));

        // Procedemos a la creacion de la cuenta
        if (SPF_Account::create_account($user, $pass, $mail)) {
            $data['success_message'] = 'Your account has been created.';
        } else {
            $data['error_message'] = 'Unkown error, account not created.';
        }

        return $data;
    }

    // Metodo para renderizar la vista.
    public static function render($data = array()) {
        return SimpleForum::view('register.php', $data);
    }
}