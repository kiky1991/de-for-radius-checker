<?php

if (!class_exists('Openstreetmap')) {

    class Openstreetmap
    {
        /**
         * LatLong::$baseUri
         *
         * LatLong Base Uri.
         *
         * @access  private
         * @type    string
         */
        private $baseUri = 'https://nominatim.openstreetmap.org/';
        
        /**
         * LatLong::$header
         *
         * LatLong Header.
         *
         * @access  private
         * @type    string
         */
        private $header = array(
            'User-Agent: Mozilla/5.0 (Linux; Android 7.0; SAMSUNG SM-G610M Build/NRD90M) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/7.4 Chrome/59.0.3071.125 Mobile Safari/537.36',
        );

        /**
         * LatLong::request
         *
         * Curl request API caller.
         *
         * @param   string  $path       Path url
         * @param   array   $params     Params
         * @param   string  $type       POST or GET
         *
         * @access  protected
         * @return  array|bool|string Returns FALSE if failed.
         */
        protected function request($path = '', $params = array(), $type = 'GET')
        {
            $curl = curl_init();
            curl_setopt_array($curl, [ 
                CURLOPT_URL             => $this->baseUri . $path,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                CURLOPT_TIMEOUT         => 10,
                CURLOPT_MAXREDIRS       => 10,
                CURLOPT_CUSTOMREQUEST   => $type,
                CURLOPT_HTTPHEADER      => $this->header,
                CURLOPT_POST            => ($type == 'GET') ? 0 : 1,
                CURLOPT_POSTFIELDS      => $params,
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) return $err;

            $body = json_decode($response, true);
            return is_array($body) ? $body : false;
        }

        public function search($fields)
        {
            return $this->request(sprintf('search?%s', http_build_query($fields)));
        }
    }
}