<?php
require_once APPPATH.'libraries/service_proxy.php';
require_once APPPATH.'libraries/manager_proxy.php';
require_once APPPATH.'libraries/model_proxy.php';
/**
 * @author ahlon
 */
class Base_service {
    private $services;
    private $managers;
    private $models;
    
    protected $model;
    protected $ci;

    public $level;
    
    function __construct($model = false) {
        $this->ci = &get_instance();
        $this->services = array();
        $this->managers = array();
        $this->models = array();
        $this->ci->load->helper("utils_helper");
        if (!empty($model)) {
            $this->model = $model;                
//             if ($model instanceof Base_model) {
//             } else {
//                 $this->model = $this->$model;
//             }
        } else {
            $this->model = $this->base_model;            
        }
    }
    
    function save($bo) {
        return $this->model->save($bo);
    }
    
    function get($id) {
        return $this->model->load($id);
    }
    
    function get_one($params) {
        return $this->model->find_one($params);
    }
    
    function get_all() {
        return $this->model->find_all(array(), 'id');
    }
    
    function search($params, $orderby=false, $pagesize=false, $page=false) {
        return $this->model->find_all($params, $orderby, $pagesize, $page);
    }
    
    function count($params) {
        return $this->model->count($params);
    }
    
    function update($parmas, $kvs) {
        return $this->model->update($parmas, $kvs);
    }
    
    function delete($params) {
        return $this->model->delete($params);
    }
    
    function __get($name) {
        if (is_end_with($name, '_model')) {
            $this->models[] = $name;
        }
        if (is_end_with($name, '_manager')) {
            $this->managers[] = $name;
        }
        if (is_end_with($name, '_service')) {
            $this->services[] = $name;
        }
    
        if (is_end_with($name, '_model') && is_file($model_file = APPPATH . 'models/' . $name . '.php')) {
            $proxy = new Model_proxy($name);
            $proxy->set_level($this->level + 1);
            return $this->$name = $proxy;
        }
    
        if (is_end_with($name, '_manager') && is_file($manager_file = APPPATH . 'managers/' . $name . '.php')) {
            $proxy = new Manager_proxy($name);
            $proxy->set_level($this->level + 1);
            return $this->$name = $proxy;
        }
    
        if (is_end_with($name, '_service') && is_file($service_file = APPPATH . 'services/' . $name . '.php')) {
            $proxy = new Service_proxy($name);
            $proxy->set_level($this->level + 1);
            return $this->$name = $proxy;
        }
        $class = get_class($this);
        $array = debug_backtrace();
        log_message('error', $name.' not found in service['.$class.'], pls check the code, '.json_encode($array[0]));
    }
}