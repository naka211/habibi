<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Group extends MX_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct() {
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string())); 
        $this->lang->load('access');
        $this->load->model('group_model','group');
        $this->language = $this->lang->lang(); 
    }
    function index($page=0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/group/add';
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'group/list';
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
        $total = $this->group->getNumData();
        $list = $this->group->getAllData($limit,$offset);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->group_id = $row->group_id;
                $data->group_name = $row->group_name;
                $data->group_comment = $row->group_comment;
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/group/edit/'.$row->group_id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->group_id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'admin_group'","'group_id'",$row->group_id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->group_id.'" name="linkDelete-'.$row->group_id.'" value="'.site_url($this->module_name."/group/del/").'"/>';
                    $data->action .= icon_delete($row->group_id);
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
    
    function data_group(){
        $data['group_name']    = $this->input->post('group_name');
        $data['group_comment'] = $this->input->post('group_comment');
        $data['bl_active'] = 1;
        return $data;
    }
    function data_right($post){
        $data['group_id'] = $post['group_id'];
        $data['module_id'] = $post['module_id'];
        $data['function_id'] = $post['function_id'];
        return $data;
    }
    function add(){
        $this->check->check('add','','',base_url());
        $this->form_validation->set_rules('group_name',lang('access.group.name'),'trim|required'); 
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }else{
            $data_group = $this->data_group();
            $group_id = $this->group->saveData($data_group);
            if($group_id){
                $arr_right = $this->input->post('arr_right');
                $arr_permission = $this->input->post('arr_permission');
                for($i = 0; $i < sizeof($arr_right); $i ++) {
                    $arr_right[$i]['group_id'] = $group_id;
                    $data_right = $this->data_right($arr_right[$i]);
                    $data_right['permission'] = json_encode($arr_permission[$i]);
                    $this->group->saveRight($data_right,$arr_right[$i]['right_id']);
                }
               $this->session->set_flashdata('message',lang('admin.save_successful'));
               redirect(site_url($this->module_name.'/group'));
            }else{
               $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['message'] = $this->message;
        $data['modules'] = $this->group->getAllModule();
        $data['permission'] = $this->group->getAllPermission();
        $arr_code_permission = array();
        if(count($data['permission'])>0){
            foreach($data['permission'] as $pm_code){
                $arr_code_permission[] = $pm_code->permission_code;
            }
        }
        $data['arr_pm_code'] = $arr_code_permission;
        $data['title'] = lang('admin.add');

        $data['page'] = 'group/add';
        $this->load->view('templates', $data);
    }
    function edit($id){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('group_name',lang('access.group.name'),'trim|required');
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }else{
            $data_group = $this->data_group();
            if($this->group->saveData($data_group,$id)){
                $arr_right = $this->input->post('arr_right');
                $arr_permission = $this->input->post('arr_permission');
                for($i = 0; $i < sizeof($arr_right); $i ++) {
                    $data_right = $this->data_right($arr_right[$i]);
                    if(!$arr_permission[$i]){
                        $arr_permission[$i] = array();
                    }
                    $data_right['permission'] = json_encode($arr_permission[$i]);
                    $this->group->saveRight($data_right,$arr_right[$i]['right_id']);
                }
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/group'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->group->getGroupId($id);
        $data['message'] = $this->message;
        $data['modules'] = $this->group->getAllModule();
        $data['permission'] = $this->group->getAllPermission();
        $arr_code_permission = array();
        if(count($data['permission'])>0){
            foreach($data['permission'] as $pm_code){
                $arr_code_permission[] = $pm_code->permission_code;
            }
        }
        $data['arr_pm_code'] = $arr_code_permission;
        $data['title'] = lang('admin.edit');
        $data['page'] = 'group/edit';
        $this->load->view('templates', $data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->group->deleteData($id)){
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
                    if($this->group->deleteData($itemid[$i])){
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
/* Location: ./admin/groups/system/controllers/group.php */