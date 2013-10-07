<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


include("pchart/class/pData.class.php");
include("pchart/class/pDraw.class.php");
include("pchart/class/pImage.class.php");
include("pchart/class/pIndicator.class.php");
/**
* Zend Framework Loader
*
* Put the 'Zend' folder (unpacked from the Zend Framework package, under 'Library')
* in CI installation's 'application/libraries' folder
* You can put it elsewhere but remember to alter the script accordingly
*
* Usage:
* 1) $this->load->library('zend', 'Zend/Package/Name');
* or
* 2) $this->load->library('zend');
* then $this->zend->load('Zend/Package/Name');
*
* * the second usage is useful for autoloading the Zend Framework library
* * Zend/Package/Name does not need the '.php' at the end
*/
class CI_Zend
{
    /**
    * Constructor
    *
    * @param	string $class class name
    */
    public function __construct($class = NULL)
    {
        // include path for Zend Framework
        // alter it accordingly if you have put the 'Zend' folder elsewhere
        //var_dump(ini_get('include_path'));
        
        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . BASEPATH . 'libraries/Zend');
        
        //var_dump(ini_get('include_path'));
        if($class)
        {
            require_once (string) $class . EXT;
            log_message('debug', "Zend Class $class Loaded");
        }
        else
        {
            log_message('debug', "Zend Class Initialized");
        }
    }

    /**
    * Zend Class Loader
    *
    * @param	string $class class name
    */
    public function load($class)
    {
        
        //var_dump(ini_get('include_path'));
        //
        //
        //require_once (string) $class . EXT;
        
        
        //var_dump(BASEPATH . 'libraries/Zend/Json/'. $class . EXT);
        require_once (string) BASEPATH . 'libraries/'. $class . EXT;
        log_message('debug', "Zend Class $class Loaded");
    }
}
