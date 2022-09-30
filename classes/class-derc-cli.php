<?php

/**
 * Do some stuff antikpedia-core using WP_CLI
 * 
 * Do not let non developer for handle our plugin
 */
if (!class_exists('DERC_Cli')) {

    class DERC_Cli
    {
        /**
         * DERC_Cli::__construct
         * 
         * run construct of DERC_Cli
         */
        public function __construct()
        {
            if (!class_exists('WP_CLI')) {
                return;
            }
            
            $this->openstreetmap = new Openstreetmap();
            $this->checker       = new DERC_Checker(); 
            WP_CLI::add_command('derc', 'DERC_Cli');
        }

        /**
         * run api command using cli 
         * DERC_Cli::api
         * 
         * usage `wp derc api --args=value`   
         * 
         * @param   array   $args
         * @param   array   $assoc_args
         * 
         * @return  string  success/error
         */
        public function test($args, $assoc_args)
        {
            if (isset($assoc_args['openstreetmap'])) {
                switch ($assoc_args['openstreetmap']) {
                    case 'search':
                        $search = $this->openstreetmap->search(array(
                            'q'         => 'bandung',
                            'format'    => 'json'
                        ));
                        var_dump($search);die;
                        break;
                }
            }
            
            if (isset($assoc_args['checker'])) {
                switch ($assoc_args['checker']) {
                    case 'polygon':
                        $polygon = array("22.73549852921309 75.85424423217773","22.72346544538196 75.85561752319336","22.72346544538196 75.87175369262695","22.732332030848273 75.87295532226562","22.740406456758326 75.8686637878418","22.74198962160603 75.85407257080078");
                        $inradius = $this->checker->pointInPolygon("22.732965336387213 75.8609390258789", $polygon);
                        
                        echo ($inradius ? 'In Radius' : 'Outside') . PHP_EOL;
                        break;
                }
            }
        }
    }
}