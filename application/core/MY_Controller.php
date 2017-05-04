<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once (APPPATH . 'helpers/languagesetup_helper' . EXT);
require_once (APPPATH . 'helpers/custom_helper' . EXT);
require_once (APPPATH . 'helpers/setting_helper' . EXT);

class MY_Controller extends MX_Controller {
    
    public $globalData;


    public function __construct() {
        
        $CI = & get_instance();
        parent::__construct();      
        
        $controllerName = $this->router->fetch_class();
        $methodName = $this->router->fetch_method();
               
        
        $this->preSetupSystem();
                
        $_SESSION['languageId']=1;
        $_SESSION['langCode']='en';
        $_SESSION['languageFolder'] = 'english';
        

        //==lock language file=======        
        $this->config->set_item('language', $_SESSION['languageFolder']);       
        
        //==load the language files=======
        $this->lang->load('app', $_SESSION['languageFolder']);

        //==theme setup
        $this->themeSetup();  
        
        $globalData['controllerName']= strtolower($controllerName);
        $globalData['methodName']= strtolower($methodName);      
        
        $this->load->vars($globalData);
    }

    
    function preSetupSystem(){
        
        //==site wise timezone settings
       date_default_timezone_set('America/Chicago');   
    }
    
    function themeSetup(){
        $theme = getThemeName();
        
        $this->theme = $theme . '/';
        $this->template->set_master_template($theme . '/template.php');

        if (!defined('THEME_LOCATION')) {
            define('THEME_LOCATION', $this->theme);
        }
        if (!defined('THEME_ASSETS_LOCATION')) {
            define('THEME_ASSETS_LOCATION', 'themes/' . $this->theme . 'assets/');
        }
    }
    

}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */