<?php

if (!class_exists('DERC_Ajax')) {

    class DERC_Ajax
    {
        public function __construct()
        {
            $this->openstreetmap = new Openstreetmap();
            $this->setting       = new DERC_Setting();

            add_action('wp_ajax_derc_check_address', array($this, 'check_address'));
            add_action('wp_ajax_nopriv_derc_check_address', array($this, 'check_address'));
        }

        public function check_address()
        {
            check_ajax_referer('derc-check-address-nonce', 'derc_check_address_nonce');

            $required = ['q'];
            $containsSearch = count(array_intersect($required, array_keys($_POST))) == count($required);
            if ($containsSearch <> 1) wp_die(-1);

            $setting = $this->setting->get_all();
            $keyword = sanitize_text_field(wp_unslash($_POST['q']));
            $search = $this->openstreetmap->search(array(
                'q'         => urlencode($keyword),
                'format'    => 'json'
            ));

            if (!$search || empty($search)) {
                $response = array(
                    'success'   => false,
                    'message'   => 'Search not found.'
                );
            }

            $lat = $search[0]['lat'];
            $lon = $search[0]['lon'];

            // again... i stuck in kml :(
            $inradius = false;

            // the final result should be
            $response = array(
                'is_inradius'   => $inradius,
                'keyword'       => $keyword,
                'lat'           => $lat,
                'lon'           => $lon,
                'redirect'      => $inradius ? $setting['inradius_url'] : $setting['outradius_url']
            );

            wp_send_json_success($response);
        }
    }
}