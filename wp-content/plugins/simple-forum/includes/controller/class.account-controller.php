<?php

// Gestiona las vistas relacionadas con cuentas de usuario sigin/signup/reset
class SPF_AccountController {
    // Este metodo permite a los usuario logearse en el sistema
    public static function auth($username, $password) {
        // Buscamos la cuenta de usuario indicada
        $account = SPF_Account::get_account($username);

        // La cuenta no ha sido encontrada
        if ($account === null) {
            return false;
        }

        // El password no coincide
        if (!password_verify($password, $account->password)) {
            return false;
        }

        // Autentificado con exito
        $_SESSION['account'] = $account;
        return true;
    }

    // Metodo para destruir la session del usuario
    public static function logout() {
        if (isset($_SESSION['account'])) {
            unset($_SESSION['account']);
        }
    }

    // Este metodo comprueba si el usuario ha sido autentificao o no
    public static function is_auth() {
        if (isset($_SESSION['account'])) {
            if (!empty($_SESSION['account']->id)) {
                return true; // esta autentificado
            }
        }
        return false; // no esta autentificado
    }

    // Controlador de la vista 'login.php'
    public static function login_controller() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (SPF_AccountController::is_auth()) {
                $data['error_message'] = 'You are already logged.';
                return SimpleForum::view('login.php', $data);
                //return SimpleForum::redirect_js(home_url() . '/spf-show-forums');
            }

            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);

            if (empty($user) || empty($pass)) {
                $data['error_message'] = 'You must fill the fields.';
                return SimpleForum::view('login.php', $data);
            }

            if (SPF_AccountController::auth($user, $pass)) {
                return SimpleForum::redirect_js('forums');
            } else {
                $data['error_message'] = 'Invalid username/password.';
            }
        }
        
        return SimpleForum::view('login.php', $data);
    }

    // Controlador para la vista 'logout.php'
    public static function logout_controller() {
        // Si el usuario esta logeado
        if (SPF_AccountController::is_auth()) {
            // Deslogeamos al usuario
            SPF_AccountController::logout();
        }
        SimpleForum::redirect_js('login');
    }

    // Controlador de la vista 'register.php'
    public static function register_controller() {
        // Se detecto el envio de un formulario via POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);
            $pass2 = sanitize_text_field($_POST['password2']);
            $mail = sanitize_email($_POST['email']);

            // Ningun campo puede estar vacio
            if (empty($user) || empty($pass) || empty($pass2) || empty($mail)) {
                $data['error_message'] = 'Ningun campo puede estar vacio.';
                return SimpleForum::view('register.php', $data);
            }

            // Comprobamos que el usuario no exista
            if (SPF_Account::username_exists($user)) {
                $data['error_message'] = 'El nombre de usuario ya esta en uso.';
                return SimpleForum::view('register.php', $data);
            }
            
            // Comprobamos que el correo no exista
            if (SPF_Account::mail_exists($mail)) {
                $data['error_message'] = 'El email ya esta en uso.';
                return SimpleForum::view('register.php', $data);
            }
            
            // Comprobamos que las passwords coincidan
            if ($pass !== $pass2) {
                $data['error_message'] = 'Las passwords no coinciden.';
                return SimpleForum::view('register.php', $data);
            }

            // Todas las comprobaciones realizadas con exito, encriptamos el password
            $pass = password_hash($pass, PASSWORD_BCRYPT, array( 'cost' => 12 ));

            // Procedemos a la creacion de la cuenta
            if (!SPF_Account::create_account($user, $pass, $mail)) {
                $data['error_message'] = 'Hubo un error al intentar crear la cuenta.';
                return SimpleForum::view('register.php', $data);
            }
            $data['success_message'] = 'Tu cuenta ha sido creada con exito.';
        }

        return SimpleForum::view('register.php', $data);
    }

    // Controlador para la vista que cambia el password de una cuenta. 'reset.php'
    public static function reset_controller() {
    }

    // Controlador para la vista del perfil de usuario. 'profile.php'
    public static function profile_controller() {
        // Si el usuario no esta auth ...
        if (!SPF_AccountController::is_auth()) {
            $data['error_message'] = 'Acceso no autorizado.';
            return SimpleForum::view('blank.php', $data);
        }

        // ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['account']->id;
            $user = sanitize_text_field($_POST['username']);
            $actual_password = sanitize_text_field($_POST['password1']);
            $new_password = sanitize_text_field($_POST['password2']);
            $repeated_password = sanitize_text_field($_POST['password3']);
            $mail = sanitize_email($_POST['email']);
            
            // Ningun campo puede estar vacio (excepto el de nuevo password)
            if (empty($user) || empty($actual_password) || empty($mail)) {
                $data['error_message'] = 'Ningun campo puede estar vacio.';
                return SimpleForum::view('profile.php', $data);
            }

            // Si el usuario no quiere cambiar el password, ponemos la misma
            if (empty($new_password) || empty($repeated_password)) {
                $new_password = $actual_password;
                $repeated_password = $actual_password;
            }

            // Comprobamos que las passwords coincidan
            if ($new_password !== $repeated_password) {
                $data['error_message'] = 'Las passwords no coinciden.';
                return SimpleForum::view('profile.php', $data);
            }

            // El password no es valido
            if (!password_verify($actual_password, $_SESSION['account']->password)) {
                $data['error_message'] = 'Incorrect password.';
                return SimpleForum::view('profile.php', $data);
            }
            
            // Encriptamos el password
            $pass = password_hash($new_password, PASSWORD_BCRYPT, array( 'cost' => 12 ));

            if (SPF_Account::update_account($user_id, $user, $pass, $mail)) {
                $_SESSION['account']->username = $user;
                $_SESSION['account']->password = $pass;
                $_SESSION['account']->email = $mail;
                $data['success_message'] = 'Informacion actualizada.';
            } else {
                $data['error_message'] = 'No se pudo actualizar.';
            }
        }

        return SimpleForum::view('profile.php', $data);
    }
}
