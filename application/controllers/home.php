<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct()
	{
		parent::__construct();
        
        $this->layout->title('Home');
	}	
	
	public function index()
	{  
        $this->layout->output();
	}
    
    public function paginanaoencontrada()
    {
        $this->layout->output();
    }
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */