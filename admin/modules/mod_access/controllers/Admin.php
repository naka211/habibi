<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller{
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
      
    function index($page=0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/admin/add';
        }
        $data['title'] = lang("admin.list");
        $data['page'] = 'admin/list';
        $this->load->view('templates', $data);
    }
    function getContent(){
        if($_GET['limit']){
            $limit = $_GET['limit'];
        }else{
            $limit = 10;
        }
        if($this->session->userdata('offset')){
            $offset = $this->session->userdata('offset');
        }else{
            $offset = $_GET['offset'];
        }
        $total = $this->admin->getNumData();
        $list = $this->admin->getAllData($limit,$offset);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->username = $row->username;
                $data->email = $row->email;
                $data->group_name = $row->group_name;
                $data->dt_create = ($row->dt_create)?date('d/m/Y',$row->dt_create):'';
                $data->dt_login = ($row->dt_login)?date('d/m/Y H:m:s',$row->dt_login):'';
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/admin/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'admin'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/admin/del/").'"/>';
                    $data->action .= icon_delete($row->id);
                }
                $rows[] = $data;
            }
        }else{
            $rows = array();
        }
        $return['rows'] = $rows;
        $return['total'] = $total;
        header('Content-Type: application/json');
        echo json_encode($return);
        return;
    }
    function add(){              
        $this->check->check('add','','',base_url());
        $this->form_validation->set_rules('username',lang('access.username'),'trim|required');
        $this->form_validation->set_rules('email',lang('access.email'),'trim|required|valid_email');
        $this->form_validation->set_rules('password',lang('access.password'),'trim|required');
        $this->form_validation->set_rules('repassword',lang('access.password.confirm'),'trim|required|matches[password]');
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }
        else{
            $DB['username'] = $this->input->post('username',true);
            $DB['email']    = $this->input->post('email',true);
            $DB['password'] = md5($this->input->post('password',true));
            $DB['group_id'] = $this->input->post('group_id',true);
            $DB['dt_create'] = time();
            $id = $this->admin->saveData($DB);
            if($id){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/admin'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['list_group'] = $this->admin->getAllGroup();
        $data['title'] = lang('admin.add');
        $data['message'] = $this->message;
        $data['page'] = 'admin/add';
        $this->load->view('templates', $data);
    }
    function edit($id,$page=0){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('username',lang('access.username'),'trim|required');
        $this->form_validation->set_rules('email',lang('access.email'),'trim|required|valid_email');
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }
        else{
            $id = $this->input->post('id',true);
            $DB['username'] = $this->input->post('username',true);
            $DB['email']    = $this->input->post('email',true);
            if($this->input->post('password',true)){
                $DB['password'] = md5($this->input->post('password',true));
            }
            $DB['group_id'] = $this->input->post('group_id',true);
            $id = $this->admin->saveData($DB,$id);
            if($id){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/admin/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->admin->getData($id);
        $data['title'] = lang('admin.edit');
        $data['list_group'] = $this->admin->getAllGroup();
        $data['message'] = $this->message;
        $data['page'] = 'admin/edit';
        $this->load->view('templates', $data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->admin->deleteData($id)){
                $data['status'] = true;
                $data['message'] = lang('admin.delete_successful');
            }else{
                $data['status'] = false;
                $data['message'] = lang('admin.delete_unsuccessful');
            }
        }else{
            $data['status'] = false;
            $data['message'] = lang('admin.delete_unsuccessful');
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }
    function dels(){
        $this->check->check('dels','','');
        $itemid = $this->input->post('id',true);
        if($itemid){
            for($i = 0; $i < sizeof($itemid); $i++){
                if($itemid[$i]){
                    if($this->admin->deleteData($itemid[$i])){
                        $data['status'] = true;
                        $data['message'] = lang('admin.delete_successful');
                    }else{
                        $data['status'] = false;
                        $data['message'] = lang('admin.delete_unsuccessful');
                    }
                }
            }
        }else{
            $data['status'] = false;
            $data['message'] = lang('admin.delete_unsuccessful');
        }	
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }
}
?>