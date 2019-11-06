<?php

// Controlador de la vista "settings.php"
class SPF_Admin_SettingsController {

    // Controlador de la vista "forums"
    public function view_settings() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $this->render($this->handle_forms());
        }

        return $this->render();
    }

    // Metodo para procesar los formularios (POST)
    public function handle_forms() {
        // Actualizar valor
        if (isset($_POST['update_setting'])) {
            $setting_name = sanitize_text_field($_POST['setting_name']);
            $setting_value = sanitize_text_field($_POST['setting_value']);
            if (SPF_AdminSetting::update_setting($setting_name, $setting_value)) {
                $data['success_message'] = 'The setting has been updated.';
            }
        }
        return $data;
    }

    // Metodo para renderizar la vista.
    public function render($data = array()) {
        $data['settings'] = SPF_AdminSetting::get_settings();
        return SimpleForumAdmin::view('settings.php', $data);
    }
}
