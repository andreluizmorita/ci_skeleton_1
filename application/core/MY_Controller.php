<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{  
    public function __construct()
    {
        parent::__construct();  
        
        //$this->output->cache(1680);
        $this->layout->debug['active'] = TRUE;
        
        $this->layout->title(' | ');
        
        $this->layout->meta(meta('Content-type','text/html; charset=iso-8859-1'));
        $this->layout->meta(meta('content-language','pt-PT'));
        $this->layout->meta(meta('robots','index,follow'));
        
        $this->layout->meta(meta('description',''));
        $this->layout->meta(meta('Cache-control','no-cache'));
        $this->layout->meta(meta('pragma','no-cache'));        
        
        $this->layout->js('jquery/1.8.0_min');
        $this->layout->js('jquery/easing/1.3.min');

    }
}