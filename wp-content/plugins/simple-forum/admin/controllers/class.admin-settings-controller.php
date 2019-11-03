<?php

class SPF_AdminSettingsController {

    // Controlador de la vista "forums"
    public function view_settings() {
        // Creacion de forum
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_setting'])) {
            $setting_name = sanitize_text_field($_POST['setting_name']);
            $setting_value = sanitize_text_field($_POST['setting_value']);
            if (SPF_AdminSetting::update_setting($setting_name, $setting_value)) {
                $data['success_message'] = 'The setting has been updated.';
            }
        }

        $data['settings'] = SPF_AdminSetting::get_settings();
        SimpleForumAdmin::view('settings.php', $data);
    }
}
