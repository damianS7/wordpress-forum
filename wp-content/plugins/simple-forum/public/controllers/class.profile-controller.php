<?php
// Controlador para la vista "profile.php"
class SPF_ProfileController {

    // Controlador para la vista del perfil de usuario. 'profile.php'
    public static function view_profile() {
        // Si el usuario no esta auth ...
        if (!SPF_AccountController::is_auth()) {
            $data['error_message'] = 'Unauthorized access.';
            return SimpleForum::view('blank.php', $data);
        }

        // Si el usuario envia datos para actualizar su cuenta ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return SPF_ProfileController::render(SPF_ProfileController::handle_forms());
        }
        
        return SPF_ProfileController::render();
    }

    // Metodo para procesar los formularios (POST)
    public static function handle_forms() {
        // ID del usuario
        $user_id = $_SESSION['account']->id;

        // Filtrado de datos enviados por el usuario
        $username = sanitize_text_field($_POST['username']);
        $actual_password = sanitize_text_field($_POST['password1']);
        $new_password = sanitize_text_field($_POST['password2']);
        $repeated_password = sanitize_text_field($_POST['password3']);
        $mail = sanitize_email($_POST['email']);

        // Ningun campo puede estar vacio (excepto el de nuevo password)
        if (empty($username) || empty($actual_password) || empty($mail)) {
            $data['error_message'] = 'All fields must be filled.';
            return $data;
        }
            
        // Si el usuario no quiere cambiar el password, ponemos la misma
        if (empty($new_password) || empty($repeated_password)) {
            $new_password = $actual_password;
            $repeated_password = $actual_password;
        }

        // Comprobamos que las passwords coincidan
        if ($new_password !== $repeated_password) {
            $data['error_message'] = 'Passwords does not match.';
            return $data;
        }

        // El password no es valido
        if (!password_verify($actual_password, $_SESSION['account']->password)) {
            $data['error_message'] = 'Incorrect password.';
            return $data;
        }
            
        // Encriptamos el password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT, array( 'cost' => 12 ));

        // Si todas las comprobacioness de seguridad pasaron con exito, actualizamos.
        if (SPF_Account::update_account($user_id, $username, $hashed_password, $mail)) {
            $data['success_message'] = 'Account data has been updated.';
            $_SESSION['account']->username = $username;
            $_SESSION['account']->password = $hashed_password;
            $_SESSION['account']->email = $mail;
        } else {
            $data['error_message'] = 'Account data can not been updated.';
        }

        return $data;
    }

    // Metodo para renderizar la vista.
    public static function render($data = array()) {
        return SimpleForum::view('profile.php', $data);
    }
}