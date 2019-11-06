<?php

// Controlador de la vista 'login.php'
class SPF_LoginController {
    public static function view_login() {
        // Si el usuario esta auth ...
        if (SPF_AccountController::is_auth()) {
            $data['error_message'] = 'You are already logged.';
            return SimpleForum::view('blank.php', $data);
        }

        // Si el usuario envia datos para actualizar su cuenta ...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return SPF_LoginController::render(SPF_LoginController::handle_forms());
        }
        
        return SPF_LoginController::render();
    }

    // Metodo para procesar los formularios (POST)

    public static function handle_forms() {
        // Filtrado de variables introducidas por el usuario
        $username = sanitize_text_field($_POST['username']);
        $password = sanitize_text_field($_POST['password']);

        // Los campos no pueden estar vacios
        if (empty($username) || empty($password)) {
            $data['error_message'] = 'You must fill the fields.';
            return $data;
        }

        // Buscamos la cuenta de usuario indicada
        $account = SPF_Account::get_account($username);

        // La cuenta no ha sido encontrada
        if ($account === null) {
            $data['error_message'] = 'Invalid username.';
            return $data;
        }

        // El password no coincide
        if (!password_verify($password, $account->password)) {
            $data['error_message'] = 'Invalid password.';
            return $data;
        }

        // Cuenta no activada
        if ($account->activated == '0') {
            $data['error_message'] = 'Account is not activated.';
            return $data;
        }

        // Autentificado con exito
        $_SESSION['account'] = $account;
        return SimpleForum::redirect_to_view('forums');
    }

    // Metodo para renderizar la vista.
    public static function render($data = array()) {
        return SimpleForum::view('login.php', $data);
    }
}