<?php

// Gestiona las vistas relacionadas con cuentas de usuario sigin/signup/reset
class SPF_AccountController {
    public static function auth($username, $password) {
        $account = SPF_AccountModel::get_account($username);

        if ($account === null) {
            return false;
        }

        $_SESSION['account'] = $row;
        return true;
    }

    public static function logout() {
        if (isset($_SESSION['account'])) {
            unset($_SESSION['account']);
        }
    }

    public static function is_auth() {
        if (isset($_SESSION['account'])) {
            if (!empty($_SESSION['account']->id)) {
                return true;
            }
        }
        return false;
    }

    // Controlador de la vista "login.php"
    public static function login_controller() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si el usuario no esta logeado no puede crear topics
            if (SPF_AccountController::is_auth()) {
                $data['error_message'] = "You are already logged.";
                return SimpleForum::view('login.php', $data);
            }

            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);

            if (empty($user) || empty($pass)) {
                $data['error_message'] = "You must fill the fields.";
                return SimpleForum::view('login.php', $data);
            }

            if (SPF_AccountController::auth($user, $pass)) {
                return SimpleForum::redirect_js(home_url() . '/spf-show-forums');
            } else {
                $data['error_message'] = "Invalid username/password.";
            }
        }
        
        return SimpleForum::view('login.php', $data);
    }

    // Controlador de la vista "singup.php"
    public static function register_controller() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = sanitize_text_field($_POST['username']);
            $pass = sanitize_text_field($_POST['password']);
            $mail = sanitize_email($_POST['email']);

            if (!SPF_Account::create_account($user, $pass, $mail)) {
                $data['error_message'] = "Error al crear la cuenta.";
                return SimpleForum::view('register.php', $data);
            }
            $data['success_message'] = "Cuenta creada con exito.";
        }
        return SimpleForum::view('register.php', $data);
    }

    public static function reset_controller() {
    }

    public static function profile_controller() {
    }
}
