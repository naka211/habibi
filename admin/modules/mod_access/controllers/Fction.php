<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');
class Fction extends MX_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->lang->load('access');
        $this->load->model('fction_model','fction');
        $this->language = $this->lang->lang();       
    }
    function index($module_id,$page=0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add']= $this->module_name."/fction/add/".$module_id; 
        }
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        if($module_id){
            $this->session->set_userdata('module_id',$module_id);
        }else{
            $this->session->unset_userdata('module_id');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'fction/list';
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
        $module_id = $this->session->userdata('module_id');
        $total = $this->fction->getNumFunctionByModule($module_id);
        $list = $this->fction->getFunctionByModule($module_id,$limit,$offset);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->function_id = $row->function_id;
                $data->function_code = $row->function_code;
                $data->function_name = $row->function_name;
                $data->function_comment = $row->function_comment;
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/fction/edit/'.$module_id.'/'.$row->function_id):"";
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->function_id.'" name="linkDelete-'.$row->function_id.'" value="'.site_url($this->module_name."/fction/del/").'"/>';
                    $data->action .= icon_delete($row->function_id);
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
    function add($module_id){
        $this->check->check('add','','',base_url());
        $this->form_validation->set_rules('module_id',lang('access.module.name.module'),'required');
        $this->form_validation->set_rules('function_code',lang('access.module.code'),'trim|required');
        $this->form_validation->set_rules('function_name',lang('access.module.name'),'trim|required');
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }else{
            $DB['module_id']        = $this->input->post('module_id');
            $DB['function_code']    = $this->input->post('function_code');
            $DB['function_name']    = $this->input->post('function_name');
            $DB['function_comment'] = $this->input->post('function_comment');
            if($this->fction->saveData($DB)){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/fction/index/'.$module_id));
            }else{
                $this->message = lang('admin.save_unsuccessful');
                redirect(site_url($this->module_name.'/fction/add/'.$module_id));
            }
        }
        $data['modules'] = $this->fction->getAllModule();
        $data['title'] = lang('admin.add');
        $data['module_id'] = $module_id;
        $data['message'] = $this->message;
        $data['page'] = 'fction/add';
        $this->load->view('templates', $data);
    }
    function edit($module_id,$id){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('module_id','Tên module','required');
        $this->form_validation->set_rules('function_code','Code','trim|required');
        $this->form_validation->set_rules('function_name','Tên','trim|required');
        if($this->form_validation->run() == FALSE){
            $this->message = validation_errors();
        }else{
            $DB['module_id']        = $this->input->post('module_id');
            $DB['function_code']    = $this->input->post('function_code');
            $DB['function_name']    = $this->input->post('function_name');
            $DB['function_comment'] = $this->input->post('function_comment');
            if($this->fction->saveData($DB,$id)){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/fction/index/'.$module_id));
            }else{
                $this->message = lang('admin.save_unsuccessful');
                redirect(site_url($this->module_name.'/fction/'.$module_id.'/'.$id));
            }
        }
        $data['title'] = lang('admin.edit');
        $data['module_id'] = $module_id;
        $data['item'] = $this->fction->getFunctionByID($id);
        $data['modules'] = $this->fction->getAllModule();
        $data['message'] = $this->message; 
        $data['page'] = 'fction/edit';
        $this->load->view('templates', $data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->fction->deleteData($id)){
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
                    if($this->fction->deleteData($itemid[$i])){
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
/* End of file fction.php */
/* Location: ./admin/modules/system/controllers/fctioni.php */