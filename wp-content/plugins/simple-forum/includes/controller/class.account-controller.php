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

    // Controlador de la vista "login.php"
    public static function login_controller() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (SPF_AccountController::is_auth()) {
                $data['error_message'] = "You are already logged.";
                return SimpleForum::view('login.php', $data);
                //return SimpleForum::redirect_js(home_url() . '/spf-show-forums');
            }

            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);

            if (empty($user) || empty($pass)) {
                $data['error_message'] = "You must fill the fields.";
                return SimpleForum::view('login.php', $data);
            }

            if (SPF_AccountController::auth($user, $pass)) {
                return SimpleForum::redirect_js('forums');
            } else {
                $data['error_message'] = "Invalid username/password.";
            }
        }
        
        return SimpleForum::view('login.php', $data);
    }

    // Controlador para la vista "logout.php"
    public static function logout_controller() {
        // Si el usuario esta logeado
        if (SPF_AccountController::is_auth()) {
            // Deslogeamos al usuario
            SPF_AccountController::logout();
        }
        SimpleForum::redirect_js('login');
    }

    // Controlador de la vista "register.php"
    public static function register_controller() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);
            $pass2 = sanitize_text_field($_POST['password2']);
            $mail = sanitize_email($_POST['email']);

            // Ningun campo puede estar vacio
            if (empty($user) || empty($pass) || empty($pass2) || empty($mail)) {
                $data['error_message'] = "Ningun campo puede estar vacio.";
                return SimpleForum::view('register.php', $data);
            }

            // Comprobamos que el usuario no exista
            if (SPF_Account::username_exists($user)) {
                $data['error_message'] = "El nombre de usuario ya esta en uso.";
                return SimpleForum::view('register.php', $data);
            }
            
            // Comprobamos que el correo no exista
            if (SPF_Account::mail_exists($mail)) {
                $data['error_message'] = "El email ya esta en uso.";
                return SimpleForum::view('register.php', $data);
            }
            
            // Comprobamos que las passwords coincidan
            if ($pass !== $pass2) {
                $data['error_message'] = "Las passwords no coinciden.";
                return SimpleForum::view('register.php', $data);
            }

            // Todas las comprobaciones realizadas con exito, encriptamos el password
            $pass = password_hash($pass, PASSWORD_BCRYPT, array('cost'=>12));

            // Procedemos a la creacion de la cuenta
            if (!SPF_Account::create_account($user, $pass, $mail)) {
                $data['error_message'] = "Hubo un error al intentar crear la cuenta.";
                return SimpleForum::view('register.php', $data);
            }
            $data['success_message'] = "Tu cuenta ha sido creada con exito.";
        }

        return SimpleForum::view('register.php', $data);
    }

    // Controlador para la vista que cambia el password de una cuenta. "reset.php"
    public static function reset_controller() {
    }

    // Controlador para la vista del perfil de usuario. "profile.php"
    public static function profile_controller() {
    }
}
