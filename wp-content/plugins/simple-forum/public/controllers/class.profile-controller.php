<?php

class SPF_ProfileController {

    // Controlador para la vista del perfil de usuario. 'profile.php'
    public static function view_profile() {
        $data = array();

        // Si el usuario no esta auth ...
        if (!SPF_AccountController::is_auth()) {
            $data['error_message'] = 'Unauthorized access.';
            return SimpleForum::view('blank.php', $data);
        }

        // Si el usuario envia datos para actualizar su cuenta ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // ID del usuario
            $user_id = $_SESSION['account']->id;

            // Filtrado de datos enviados por el usuario
            $user = sanitize_text_field($_POST['username']);
            $actual_password = sanitize_text_field($_POST['password1']);
            $new_password = sanitize_text_field($_POST['password2']);
            $repeated_password = sanitize_text_field($_POST['password3']);
            $mail = sanitize_email($_POST['email']);
            
            // Si el usuario no quiere cambiar el password, ponemos la misma
            if (empty($new_password) || empty($repeated_password)) {
                $new_password = $actual_password;
                $repeated_password = $actual_password;
            }

            // Ningun campo puede estar vacio (excepto el de nuevo password)
            if (empty($user) || empty($actual_password) || empty($mail)) {
                $data['error_message'] = 'All fields must be filled.';
                return SimpleForum::view('profile.php', $data);
            }

            // Comprobamos que las passwords coincidan
            if ($new_password !== $repeated_password) {
                $data['error_message'] = 'Passwords does not match.';
                return SimpleForum::view('profile.php', $data);
            }

            // El password no es valido
            if (!password_verify($actual_password, $_SESSION['account']->password)) {
                $data['error_message'] = 'Incorrect password.';
                return SimpleForum::view('profile.php', $data);
            }
            
            // Encriptamos el password
            $pass = password_hash($new_password, PASSWORD_BCRYPT, array( 'cost' => 12 ));

            // Si todas las comprobacioness de seguridad pasaron con exito, actualizamos.
            if (SPF_Account::update_account($user_id, $user, $pass, $mail)) {
                $_SESSION['account']->username = $user;
                $_SESSION['account']->password = $pass;
                $_SESSION['account']->email = $mail;
                $data['success_message'] = 'Account data has been updated.';
            } else {
                $data['error_message'] = 'Account data can not been updated.';
            }
        }

        return SimpleForum::view('profile.php', $data);
    }
}
