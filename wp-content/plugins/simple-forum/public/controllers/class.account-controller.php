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
}
