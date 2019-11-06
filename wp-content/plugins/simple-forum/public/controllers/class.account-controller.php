<?php

// Gestiona las vistas relacionadas con cuentas de usuario sigin/signup/reset
class SPF_AccountController {

    // Este metodo comprueba si el usuario ha sido autentificao o no
    public static function is_auth() {
        if (isset($_SESSION['account'])) {
            if (!empty($_SESSION['account']->id)) {
                return true; // esta autentificado
            }
        }
        return false; // no esta autentificado
    }
    
    // Metodo para destruir la session del usuario
    public static function logout() {
        if (isset($_SESSION['account'])) {
            unset($_SESSION['account']);
        }
    }

    // Metodo para comprobar si el usuario esta baneado.
    public static function is_banned() {
        if ($_SESSION['account']->banned == '1') {
            return true;
        }
        return false;
    }
}