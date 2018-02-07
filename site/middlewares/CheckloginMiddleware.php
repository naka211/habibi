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
            $this->ci->session->set_flashdata('message', 'Du skal logge ind for at se det !!');
            redirect(site_url('home/index'));
        }
    }
}