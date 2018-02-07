<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Permission extends MX_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct() {
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));   
        $this->lang->load('access');
        $this->load->model('permission_model','permission');
        $this->language = $this->lang->lang();
    }
    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/permission/add';
        }
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'permission/list';
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
        $total = $this->permission->getNumPermission();
        $list = $this->permission->getPermissionPaging($limit,$offset);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->permission_id = $row->permission_id;
                $data->permission_code = $row->permission_code;
                $data->permission_name = $row->permission_name;
                $data->permission_comment = $row->permission_comment;
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/permission/edit/'.$row->permission_id.'/'.$offset):"";
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->permission_id.'" name="linkDelete-'.$row->permission_id.'" value="'.site_url($this->module_name."/permission/del/").'"/>';
                    $data->action .= icon_delete($row->permission_id);
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
        $this->form_validation->set_rules('permission_code',lang('access.permission.code'),'trim|required');
        $this->form_validation->set_rules('permission_name',lang('access.permission.name'),'trim|required'); 
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }else{
            $DB['permission_code'] = $this->input->post('permission_code',true);
            $DB['permission_name'] = $this->input->post('permission_name',true);
            $DB['permission_comment'] = $this->input->post('permission_comment',true);
            if($this->permission->saveData($DB)){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/permission'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
                redirect(site_url($this->module_name.'/permission/add'));
            }
        }
        $data['title'] = lang('admin.add');
        $data['message'] = $this->message;          
        $data['page'] = 'permission/add';
        $this->load->view('templates', $data);
    }
    function edit($id){
        $this->check->check('edit','','',base_url());  
        $this->form_validation->set_rules('permission_code',lang('access.permission.code'),'trim|required');
        $this->form_validation->set_rules('permission_name',lang('access.permission.name'),'trim|required');
        if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{  
            $DB['permission_code'] = $this->input->post('permission_code',true);
            $DB['permission_name'] = $this->input->post('permission_name',true);
            $DB['permission_comment'] = $this->input->post('permission_comment',true);
            if($this->permission->saveData($DB,$id)){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/permission'));
            }else{
                $this->pre_message = lang('admin.save_unsuccessful');
                redirect(site_url($this->module_name.'/permission/edit/'.$id));
            }
        }
        $data['title'] = lang('admin.edit');
        $data['item'] = $this->permission->getPermissionByID($id);
        $data['message'] = $this->pre_message;          
        $data['page'] = 'permission/edit';
        $this->load->view('templates', $data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->permission->deleteData($id)){
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
                    if($this->permission->deleteData($itemid[$i])){
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
/* End of file group.php */
/* Location: ./admin/webadmin/groups/system/controllers/group.php */