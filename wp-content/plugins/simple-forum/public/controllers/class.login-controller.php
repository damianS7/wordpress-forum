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
            }

            // Filtrado de variables introducidas por el usuario
            $username = sanitize_text_field($_POST['username']);
            $password = sanitize_text_field($_POST['password']);

            // Los campos no pueden estar vacios
            if (empty($username) || empty($password)) {
                $data['error_message'] = 'You must fill the fields.';
                return SimpleForum::view('login.php', $data);
            }

            // Buscamos la cuenta de usuario indicada
            $account = SPF_Account::get_account($username);

            // La cuenta no ha sido encontrada
            if ($account === null) {
                $data['error_message'] = 'Invalid username.';
                return SimpleForum::view('login.php', $data);
            }

            // El password no coincide
            if (!password_verify($password, $account->password)) {
                $data['error_message'] = 'Invalid password.';
                return SimpleForum::view('login.php', $data);
            }

            // Cuenta no activada
            if ($account->activated == '0') {
                $data['error_message'] = 'Account is not activated.';
                return SimpleForum::view('login.php', $data);
            }

            // Autentificado con exito
            $_SESSION['account'] = $account;
            return SimpleForum::redirect_to_view('forums');
        }

        return SimpleForum::view('login.php', $data);
    }
}
