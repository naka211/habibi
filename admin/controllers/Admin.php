<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller{
    function __construct(){
        parent::__construct();
        //$this->load->model('home_model', 'home');
	}
	public function index(){
        if(!$this->session->userdata('isAdmin')){
            redirect(site_url('login'));
        }
        $data['title'] = 'Administrator';
        $data['page'] = 'html/admin';
		$this->load->view('templates', $data);
	}
}
?>