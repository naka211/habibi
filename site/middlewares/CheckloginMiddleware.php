<?php
/**
 * Author: https://github.com/davinder17s
 * Email: davinder17s@gmail.com
 * Repository: https://github.com/davinder17s/codeigniter-middleware
 */

class CheckloginMiddleware {
    protected $controller;
    protected $ci;
    public $roles = array();
    public function __construct($controller, $ci)
    {
        $this->controller = $controller;
        $this->ci = $ci;
    }

    public function run(){
        if (!checkLogin()) {
            if(!empty($_COOKIE['ha_message'])){
                $message = $_COOKIE['ha_message'];
                setcookie('ha_message', '', -time() + (86400 * 300), "/");
                $this->ci->session->set_flashdata('message', $message);
            }
            redirect(site_url(''));
        }
    }
}