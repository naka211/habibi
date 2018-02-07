<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Language extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
	function __construct(){
        parent::__construct();
		$this->module_name = $this->router->fetch_module();
		$this->session->set_userdata(array('url'=>uri_string()));
		$this->load->model('language_model','langs');
        #$this->lang->load('language');
        $this->language = $this->lang->lang();
	}
	function index($page=0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/language/add';
        }
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'language/list';
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
        $total = $this->langs->getNum();
        $list = $this->langs->getAll($limit,$offset);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->code = $row->code;
                $data->name = $row->name;
                $data->flag = '<span class="flag-icon flag-icon-'.$row->code.'"></span>';
                $data->dt_create = $row->dt_create;
                $data->sort = icon_sort($row->id,$row->ordering);
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/language/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'language'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/language/del/").'"/>';
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
        $this->form_validation->set_rules('code','Code','trim|required');
        $this->form_validation->set_rules('name','Name','trim|required');
        if($this->form_validation->run()== FALSE){
            $this->message = validation_errors();
        }else{
            $DB["code"] = $this->input->post("code");
            $DB["name"] = trim($this->input->post("name"));
    		$DB["bl_active"] = 1;
    		$DB["dt_create"] = date('Y-m-d H:i:s');
            $id = $this->langs->save($DB);
            if($id){            
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/language/index'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['title'] = lang('admin.add');
		$data['message'] = $this->message;
        $data['page'] = 'language/add';
        $this->load->view('templates', $data);
	}
	function edit($id,$page=0){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('code','Code','trim|required');
		$this->form_validation->set_rules('name','Name','trim|required');
        if($this->form_validation->run()== FALSE){
            $this->message = validation_errors();
        }else{
            $DB["code"] = $this->input->post("code");
            $DB["name"] = trim($this->input->post("name"));
    		$DB["bl_active"] = 1;
    		$DB["dt_create"] = date('Y-m-d H:i:s');
            $id = $this->langs->save($DB,$id);
            if($id){            
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/language/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->langs->getItem($id);
		$data['title'] = lang('admin.edit');
		//$this->message = lang('admin.edit').": ".$data['item']->name;
        $data['message'] = $this->message;
		$data['page'] = 'language/edit';
        $this->load->view('templates', $data);
	}
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->langs->delete($id)){
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
                    if($this->langs->delete($itemid[$i])){
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