<?php

// Gestiona las vistas relacionadas con cuentas de usuario sigin/signup/reset
class SPF_RegisterController {
    
    // Controlador de la vista 'register.php'
    public static function view_register() {
        $data = array();

        // Se detecto el envio de un formulario via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filtrado de seguridad para los datos enviados por el usuario
            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);
            $pass2 = sanitize_text_field($_POST['password2']);
            $mail = sanitize_email($_POST['email']);

            // Ningun campo puede estar vacio
            if (empty($user) || empty($pass) || empty($pass2) || empty($mail)) {
                $data['error_message'] = 'All fields must be filled.';
                return SimpleForum::view('register.php', $data);
            }

            // Comprobamos que el usuario no exista
            if (SPF_Account::username_exists($user)) {
                $data['error_message'] = 'This username is already in use.';
                return SimpleForum::view('register.php', $data);
            }
            
            // Comprobamos que el correo no exista
            if (SPF_Account::mail_exists($mail)) {
                $data['error_message'] = 'This email is already in use.';
                return SimpleForum::view('register.php', $data);
            }
            
            // Comprobamos que las passwords coincidan
            if ($pass !== $pass2) {
                $data['error_message'] = 'Passwords does not match.';
                return SimpleForum::view('register.php', $data);
            }

            // Todas las comprobaciones realizadas con exito, encriptamos el password
            $pass = password_hash($pass, PASSWORD_BCRYPT, array( 'cost' => 12 ));

            // Procedemos a la creacion de la cuenta
            if (!SPF_Account::create_account($user, $pass, $mail)) {
                $data['error_message'] = 'Unkown error, account not created.';
                return SimpleForum::view('register.php', $data);
            }
            $data['success_message'] = 'Your account has been created.';
        }

        return SimpleForum::view('register.php', $data);
    }

    // Controlador para la vista que cambia el password de una cuenta. 'reset.php'
    public static function view_reset() {
    }
}
