<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('login_model', 'login');
        $this->lang->load('login');
	}
	public function index(){
        if($this->session->userdata('isAdmin')){
            redirect(site_url('admin'));
        }
        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        if($this->form_validation->run()){
            if($this->login->checklogin()){
                $this->session->set_flashdata('message',lang('login.message'));
                redirect(site_url('admin'));
            }else{
                $this->session->set_flashdata('error',lang('login.error'));
            }
        }
        $data['title'] = lang('login.title');
		$this->load->view('login', $data);
	}
    function logout(){
        $this->session->unset_userdata('isAdmin');
        redirect(base_url());
    }
}
?>