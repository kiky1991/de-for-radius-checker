<?php
/**
 * Validator for PHP 7.0+
 * Documentation https://github.com/rakit/validation
 */
use Rakit\Validation\Validator; 

if (!class_exists('DERC_Admin')) {

    class DERC_Admin
    {
        public function __construct()
        {
            $this->setting      = new DERC_Setting();
            $this->validator    = new Validator();

            add_action('admin_enqueue_scripts', array($this, 'enqueue'));
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_notices', array($this, 'display_flash_notices'));

            // setting page
            add_action('admin_post_derc_save_setting', array($this, 'save_setting'));
        }

        public function enqueue()
        {
            wp_register_style('derc-admin', DERC_PLUGIN_URI . '/assets/css/admin.css', array(), DERC_VERSION);
        }

        public function admin_menu()
        {
            add_menu_page('DE Radius Checker', 'DERC', 'administrator', 'derc', null, DERC_PLUGIN_URI . '/assets/img/location.png', 58);
            add_submenu_page('derc', __('DE Radius Checker', 'derc'), __('DE Radius Checker', 'derc'), 'administrator', 'derc', array($this, 'render_page_setting'), 50);
            remove_submenu_page('derc', 'derc');
        }

        public function render_page_setting()
        {
            $setting = $this->setting->get_all();
            wp_enqueue_style('derc-admin');

            include_once DERC_PLUGIN_PATH . 'views/admin-radius-checker.php';
        }

        public function save_setting()
        {
            // Handle nonce
            if (
                !isset($_POST['derc_save_setting_nonce'])
                || !wp_verify_nonce($_POST['derc_save_setting_nonce'], 'derc_save_setting')
            ) {
                return;
            }

            $validation = $this->validator->validate($_POST, [
                'apikey'        => 'required|alpha_dash',
                'zone_url'      => 'required|url:http,https',
                'inradius_url'  => 'required|url:http,https',
                'outradius_url' => 'required|url:http,https',
            ]);

            if ($validation->fails()) {
                $errors = $validation->errors();
                
                $this->add_flash_notice('<ul>' . implode(' ', $errors->all('<li>:message</li>')) . '</ul>', 'error', false);
                wp_safe_redirect(add_query_arg(array('page'=>'derc'), admin_url("admin.php")));
                die;
            }

            $this->setting->save_all(
                array(
                    'apikey'        => sanitize_text_field(wp_unslash($_POST['apikey'])),
                    'zone_url'      => sanitize_url($_POST['zone_url']),
                    'inradius_url'  => sanitize_url($_POST['inradius_url']),
                    'outradius_url' => sanitize_url($_POST['outradius_url'])
                )
            );

            $this->add_flash_notice('Data has been saved', 'success', true);
            wp_safe_redirect(add_query_arg(array('page'=>'derc'), admin_url("admin.php")));
            die;
        }

        public function add_flash_notice($message = '', $type = 'success', $p = true)
        {
            $old_notice = get_option('my_flash_notices', array());
            $old_notice[] = array(
                'type'      => !empty($type) ? $type : 'success',
                'message'   => $p ? '<p>' . $message . '</p>' : $message,
            );
            update_option('my_flash_notices', $old_notice, false);
        }

        public function display_flash_notices()
        {
            $notices = get_option('my_flash_notices', array());
            foreach ($notices as $notice) {
                printf(
                    '<div class="notice is-dismissible notice-%1$s">%2$s</div>',
                    esc_attr($notice['type']),
                    wp_kses_post($notice['message'])
                );
            }

            if (!empty($notices)) {
                delete_option("my_flash_notices", array());
            }
        }
    }
}