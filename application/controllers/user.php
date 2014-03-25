<?php
require_once dirname(__FILE__).'/base.php';
/**
 * @author ahlon
 */
class User extends Base_Controller {

    public function index() {
        $this->load->service('user_service');
        $users = $this->user_service->get_all();
        print_r($users);
    }
}