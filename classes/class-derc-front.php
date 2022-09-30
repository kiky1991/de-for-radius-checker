<?php

if (!class_exists('DERC_Front')) {

    class DERC_Front
    {
        public function __construct()
        {
            $this->setting  = new DERC_Setting();

            add_action('wp_enqueue_scripts', array($this, 'enqueue'));
            add_shortcode('derc-radius-checker', array($this, 'radius_checker'));
        }

        public function enqueue() 
        {
            $setting = $this->setting->get_all();
            $maps = add_query_arg(
                array(
                    'key'       => $setting['apikey'],
                    'libraries' => 'geometry',
                    'callback'  => 'initMap',
                    'v'         => 'weekly',
                ),
                'https://maps.googleapis.com/maps/api/js'
            );

            wp_register_script('derc-front', DERC_PLUGIN_URI . '/assets/js/front.js', array(), DERC_VERSION, true);
            wp_register_script('derc-geoxml', DERC_PLUGIN_URI . '/assets/js/geoxml.js', array(), DERC_VERSION, true);
            wp_register_script('derc-gmaps', $maps, array(), DERC_VERSION, true);
            wp_register_script('derc-gmaps-ssl', 'https://maps-api-ssl.google.com/maps/api/js', array(), DERC_VERSION, true);
            wp_register_script('derc-leaflet', 'https://cdnjs.cloudflare.com/ajax/libs/leaflet-omnivore/0.3.4/leaflet-omnivore.js', array(), DERC_VERSION, true);
        }

        public function radius_checker()
        {
            // only load script in shortcode page
            // wp_enqueue_script('derc-geoxml');
            // wp_enqueue_script('derc-gmaps');
            // wp_enqueue_script('derc-leaflet');
            wp_enqueue_script('derc-front');
            wp_localize_script(
                'derc-front',
                'derc',
                array(
                    'url'   => admin_url('admin-ajax.php'),
                    'nonce' => array(
                        'check_address' => wp_create_nonce('derc-check-address-nonce'),
                    )
                )
            );

            include_once DERC_PLUGIN_PATH . 'views/front-radius-checker.php';
        }
    }
}