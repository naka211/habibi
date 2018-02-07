<?php
/**
 * Author: https://github.com/davinder17s
 * Email: davinder17s@gmail.com
 * Repository: https://github.com/davinder17s/codeigniter-middleware
 */

class CheckgoldMiddleware {
    protected $controller;
    protected $ci;
    public $roles = array();
    public function __construct($controller, $ci)
    {
        $this->controller = $controller;
        $this->ci = $ci;
    }

    public function run(){
        $user = $this->ci->session->userdata('user');
        $result = $this->ci->db->select('type')->from('user')->where('id', $user->id)->get()->row();
        if ($result->type == 1) {
            $this->ci->session->set_flashdata('goldMember', 'Du skal være guldmedlem til at bruge denne funktion !!');
            redirect(site_url('home/index'));
        }
    }
}