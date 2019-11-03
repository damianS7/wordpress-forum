<?php

// Gestiona las vistas relacionadas con cuentas de usuario sigin/signup/reset
class SPF_LogoutController {
    
    // Controlador para la vista 'logout.php'
    public static function view_logout() {
        // Si el usuario esta logeado
        if (SPF_AccountController::is_auth()) {
            // Deslogeamos al usuario
            SPF_AccountController::logout();
        }

        SimpleForum::redirect_to_view('login');
    }
}
