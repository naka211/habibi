<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Changepassword extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
	function __construct(){
    parent::__construct();     
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->lang->load('access');
        $this->load->model('admin_model','admin');
        $this->language = $this->lang->lang();
    }
    function index(){
        $this->check->check('view','','',base_url());       
        $this->form_validation->set_rules('current_password',lang('access.password.current'),'trim|required');  
        $this->form_validation->set_rules('password',lang('access.password.new'),'trim|required');  
        $this->form_validation->set_rules('repassword',lang('access.password.new.confirm'),'trim|required|matches[password]'); 
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }
        else{
            $id = $this->session->userdata('id');
            $user = $this->admin->getData($id);
            if($user&&($user->password == md5($this->input->post('current_password')))){
                $DB['password'] = md5($this->input->post('password'));
                $id = $this->admin->saveData($DB,$id);
                if($id){
                    $this->session->set_flashdata('message',lang('admin.save_successful'));
                    redirect(site_url($this->module_name.'/changepassword'));
                }else{
                    $this->message = lang('admin.save_unsuccessful');
                }
            }else{
                $this->message = lang('access.password.message');
            }
        }
        $data['title'] = lang('access.password.title');
        $data['message'] = $this->message;
        $data['page'] = 'admin/changepassword';
        $this->load->view('templates', $data);
    }
}
?>