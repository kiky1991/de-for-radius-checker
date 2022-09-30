<?php

if (!class_exists('DERC_Setting')) {

    /**
     * Class Setting
     */
    class DERC_Setting
    {
        public function __construct()
        {
            $this->option_name_setting = 'derc_settings';
            $this->setting = get_option($this->option_name_setting, $this->get_defaults());
        }

        /**
         * Get default values
         *
         * @param  string $index Defaults index.
         * @return mixed         Default value.
         */
        public function get_defaults($index = null)
        {
            $defaults = apply_filters(
                'derc_setting_defaults',
                array(
                    'apikey'        => '',
                    'zone_url'      => '',
                    'inradius_url'  => '',
                    'outradius_url' => '',
                )
            );

            if (!is_null($index)) {
                if (isset($defaults[$index])) {
                    return $defaults[$index];
                } else {
                    return false;
                }
            }

            return $defaults;
        }

        /**
         * Save settings
         *
         * @param  array $settings Setting values.
         */
        public function save($settings = array())
        {
            $new_value = wp_parse_args($settings, $this->get_defaults());
            update_option($this->option_name_setting, $new_value, true);
            $this->setting = get_option($this->option_name_setting, $this->get_defaults());
        }

        /**
         * Save all settings
         *
         * @param  array $settings Setting values.
         */
        public function save_all($settings = array())
        {
            update_option($this->option_name_setting, $settings, true);
            $this->setting = get_option($this->option_name_setting, $this->get_defaults());
        }

        /**
         * Get all settings into one array
         *
         * @return array Setting values
         */
        public function get_all()
        {
            return wp_parse_args($this->setting, $this->get_defaults());
        }
    }
}