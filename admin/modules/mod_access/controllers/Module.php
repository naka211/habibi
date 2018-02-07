<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Module extends MX_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct() {
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string())); 
        $this->lang->load('access');
        $this->load->model('module_model','module');
        $this->language = $this->lang->lang();        
    }
    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/module/add';
        }
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'module/list';
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
        $total = $this->module->getNumData();
        $list = $this->module->getAllData($limit,$offset);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->module_id = $row->module_id;
                $data->module_code = $row->module_code;
                $data->module_name = $row->module_name;
                $data->module_comment = $row->module_comment;
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('add'))?icon_add($this->module_name.'/fction/index/'.$row->module_id):"";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/module/edit/'.$row->module_id.'/'.$offset):"";
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->module_id.'" name="linkDelete-'.$row->module_id.'" value="'.site_url($this->module_name."/module/del/").'"/>';
                    $data->action .= icon_delete($row->module_id);
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
        $this->form_validation->set_rules('module_code',lang('access.module.code.module'),'trim|required');  
        $this->form_validation->set_rules('module_name',lang('access.module.name.module'),'trim|required'); 
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }else{
            $code = $this->input->post('module_code');
            if($this->module->checkCode($code)){
                $DB['module_code'] = $this->input->post('module_code',true);
                $DB['module_name'] = $this->input->post('module_name',true);
                $DB['module_comment'] = $this->input->post('module_comment',true);
                if($this->module->saveData($DB)){
                    $this->session->set_flashdata('message',lang('admin.save_successful'));
                    redirect(site_url($this->module_name.'/module'));
                }else{
                    $this->message = lang('admin.save_unsuccessful');
                    redirect(site_url($this->module_name.'/module/add'));
                }
            }else{
                $this->message = lang('access.module.message');
            }
        }
        $data['title'] = lang('admin.add');
        $data['message'] = $this->message;          
        $data['page'] = 'module/add';
        $this->load->view('templates', $data);
    }
    function edit($id){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('module_code',lang('access.module.code.module'),'trim|required');  
        $this->form_validation->set_rules('module_name',lang('access.module.name.module'),'trim|required');
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }else{
            $code = $this->input->post('module_code');
            if($this->module->checkCode($code,$id)){
                $DB['module_code'] = $this->input->post('module_code',true);
                $DB['module_name'] = $this->input->post('module_name',true);
                $DB['module_comment'] = $this->input->post('module_comment',true);
                if($this->module->saveData($DB,$id)){
                    $this->session->set_flashdata('message',lang('admin.save_successful'));
                    redirect(site_url($this->module_name.'/module'));
                }else{
                    $this->message = lang('admin.save_unsuccessful');
                    redirect(site_url($this->module_name.'/edit/'.$id));
                }
            }else{
                $this->message = lang('access.module.message');
            }
        }
        $data['title'] = lang('admin.edit');
        $data['item'] = $this->module->getDataID($id);
        $data['message'] = $this->message;          
        $data['page'] = 'module/edit';
        $this->load->view('templates', $data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->module->deleteData($id)){
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
                    if($this->module->deleteData($itemid[$i])){
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
/* End of file module.php */
/* Location: ./admin/modules/mod_access/controllers/module.php */