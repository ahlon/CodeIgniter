<?php
require_once dirname(__FILE__) . '/base_model.php';

class User_model extends Base_Model {
    
    public function __construct() {
        parent::__construct('users');
    }
    
}