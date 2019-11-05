<?php

class SPF_Admin_AccountController {
    public function view_accounts() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $account_id = sanitize_text_field($_POST['account_id']);
            
            // Borrado de cuenta
            if (isset($_POST['delete_account'])) {
                if (SPF_Admin_Account::delete_account($account_id)) {
                    $data['success_message'] = 'The account has been deleted.';
                }
            }

            // Actualizacion de username/mail
            if (isset($_POST['update_account'])) {
                $username = sanitize_text_field($_POST['account_username']);
                $email = sanitize_text_field($_POST['account_mail']);

                if (SPF_Admin_Account::update_account_info($account_id, $username, $email)) {
                    $data['success_message'] = 'The account has been update.';
                }
            }
            
            // Ban
            if (isset($_POST['ban_account'])) {
                if (SPF_Admin_Account::ban_account($account_id)) {
                    $data['success_message'] = 'The account has been banned.';
                }
            }
            
            // Confirm
            if (isset($_POST['confirm_account'])) {
                if (SPF_Admin_Account::confirm_account($account_id)) {
                    $data['success_message'] = 'The account has been confirmed.';
                }
            }

            // Reset password
            if (isset($_POST['reset_password'])) {
                $username = sanitize_text_field($_POST['account_username']);
                $password = sanitize_text_field($_POST['account_password']);
                
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT, array( 'cost' => 12 ));
                    if (SPF_Admin_Account::reset_password($account_id, $hashed_password)) {
                        $data['success_message'] = 'New password for: ' . $username . ' ' . $password;
                    }
                }
            }
        }
 
        $data['accounts'] = SPF_Admin_Account::get_accounts();
        SimpleForumAdmin::view('accounts.php', $data);
    }
}
