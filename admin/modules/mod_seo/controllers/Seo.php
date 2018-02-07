<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Seo extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
	function __construct(){
        parent::__construct();
		$this->module_name = $this->router->fetch_module();
		$this->session->set_userdata(array('url'=>uri_string()));
		$this->load->model('seo_model','seo');
        $this->lang->load('seo');
        $this->language = $this->lang->lang();
	}
	
	function index($page=0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/seo/add';
        }       
        $data['title'] = lang('admin.list');
        $data['page'] = 'seo/list';
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
        $total = $this->seo->get_num_seo();
        $list = $this->seo->get_all_seo($limit,$offset);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->code = $row->code;
                $data->name = $row->name;
                $data->dt_create = $row->dt_create;
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/seo/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'seo'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/seo/del/").'"/>';
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
        $this->form_validation->set_rules('code',lang('seo.code'),'trim|required');
        $this->form_validation->set_rules('name',lang('seo.name'),'trim|required');
        $this->form_validation->set_rules('meta_title',lang('seo.title'),'trim|required');
        $this->form_validation->set_rules('meta_keywords',lang('seo.keywords'),'trim|required');
    	$this->form_validation->set_rules('meta_description',lang('seo.description'),'trim|required');
        if($this->form_validation->run()== FALSE){
            $this->message = validation_errors();
        }else{
            $config['upload_path'] = $this->config->item('root')."uploads/seo/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=""){
    			if ($this->upload->do_upload('image')){	
    				$data_img = $this->upload->data();
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/seo/add'));
    			}
    		}else {
    			$data_img['file_name'] = NULL;
    		}
            $DB['image'] = $data_img['file_name'];
            $DB["code"] = $this->input->post("code");
            $DB["name"] = trim($this->input->post("name"));
    		$DB["meta_title"] = trim($this->input->post("meta_title"));
    		$DB["meta_keywords"] = trim($this->input->post("meta_keywords"));
            $DB["meta_description"] = trim($this->input->post("meta_description"));
    		$DB["bl_active"] = 1;
    		$DB["dt_create"] = date('Y-m-d H:i:s');
            $id = $this->seo->save_seo($DB);
            if($id){            
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/seo/index'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['title'] = lang('admin.add');
		$data['message'] = $this->message;
        $data['page'] = 'seo/add';
        $this->load->view('templates', $data);
	}
	function edit($id,$page=0){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('code',lang('seo.code'),'trim|required');
		$this->form_validation->set_rules('name',lang('seo.name'),'trim|required');
        $this->form_validation->set_rules('meta_title',lang('seo.title'),'trim|required');
        $this->form_validation->set_rules('meta_keywords',lang('seo.keywords'),'trim|required');
    	$this->form_validation->set_rules('meta_description',lang('seo.description'),'trim|required');
        if($this->form_validation->run()== FALSE){
            $this->message = validation_errors();
        }else{
            $config['upload_path'] = $this->config->item('root')."uploads/seo/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=""){
    			if($this->upload->do_upload('image')){	
    				$data_img = $this->upload->data();
                    $DB['image'] = $data_img['file_name'];
    			}else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/seo/edit/'.$id.'/'.$page));
    			}
    		}
            $DB["code"] = $this->input->post("code");
            $DB["name"] = trim($this->input->post("name"));
    		$DB["meta_title"] = trim($this->input->post("meta_title"));
    		$DB["meta_keywords"] = trim($this->input->post("meta_keywords"));
            $DB["meta_description"] = trim($this->input->post("meta_description"));
    		$DB["bl_active"] = 1;
    		$DB["dt_create"] = date('Y-m-d H:i:s');
            $id = $this->seo->save_seo($DB,$id);
            if($id){            
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/seo/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->seo->get_seo_item($id);
		$data['title'] = lang('admin.edit');
		//$this->message = lang('admin.edit').": ".$data['item']->name;
        $data['message'] = $this->message;
		$data['page'] = 'seo/edit';
        $this->load->view('templates', $data);
	}
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->seo->deleteData($id)){
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
                    if($this->seo->deleteData($itemid[$i])){
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