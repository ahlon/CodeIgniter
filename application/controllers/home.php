<?php
require_once dirname(__FILE__).'/base.php';
/**
 * @author ahlon
 */
class Home extends Base_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->layout = 'layouts/common_layout';
        $this->widgets['header'] = new Widget('header', $this->data);
        $this->widgets['footer'] = new Widget('footer', $this->data);
    }
    
    public function login() {
        $this->load->view('login');
    }
    
    function logout() {
    
    }
    
    function register() {
        
    }
}