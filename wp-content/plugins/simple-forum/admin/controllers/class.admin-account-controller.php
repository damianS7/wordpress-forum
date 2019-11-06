<?php

// Controlador de la vista "accounts.php"
class SPF_Admin_AccountsController {
    public function view_accounts() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->render($this->handle_forms());
        }
        return $this->render();
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        $username = sanitize_text_field($_POST['account_username']);
        $data['searched_username'] = $username;
            
        // Buscamos una cuenta
        if (isset($_POST['search_account'])) {
            $data['accounts'] = SPF_Admin_Account::get_account($username);
            return $data;
        }

        // A partir de aqui todos los POST incluyen el id de la cuenta
        $account_id = sanitize_text_field($_POST['account_id']);
            
        // Borrado de cuenta
        if (isset($_POST['delete_account'])) {
            if (SPF_Admin_Account::delete_account($account_id)) {
                $data['success_message'] = 'The account has been deleted.';
            }
        }

        // Actualizacion de username/mail
        if (isset($_POST['update_account'])) {
            $email = sanitize_text_field($_POST['account_mail']);

            if (SPF_Admin_Account::update_account_info($account_id, $username, $email)) {
                $data['success_message'] = 'The account has been updated.';
            }
        }
            
        // Banear la cuenta
        if (isset($_POST['ban_account'])) {
            if ($_POST['banned'] == '1') {
                SPF_Admin_Account::unban_account($account_id);
                $data['success_message'] = 'The account has been unbanned.';
            } else {
                SPF_Admin_Account::ban_account($account_id);
                $data['success_message'] = 'The account has been banned.';
            }
        }
            
        // Activar cuenta
        if (isset($_POST['activate_account'])) {
            if (SPF_Admin_Account::activate_account($account_id)) {
                $data['success_message'] = 'The account has been activated.';
            }
        }

        // Reset password
        if (isset($_POST['reset_password'])) {
            // Password enviada por el usuario
            $password = sanitize_text_field($_POST['account_password']);
                
            // Si el password no esta en blanco
            if (!empty($password)) {
                // Obtenemos el hash del password introducido
                $hashed_password = password_hash($password, PASSWORD_BCRYPT, array( 'cost' => 12 ));
                
                // Cambiamos el password
                if (SPF_Admin_Account::update_password($account_id, $hashed_password)) {
                    $data['success_message'] = 'New password for: ' . $username . ' ' . $password;
                }
            }
        }

        $data['accounts'] = SPF_Admin_Account::get_account($username);
        return $data;
    }

    // Metodo para renderizar la vista.
    public function render($data = array()) {
        return SimpleForumAdmin::view('accounts.php', $data);
    }
}
