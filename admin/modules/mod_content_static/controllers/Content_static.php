<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Content_Static extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
	function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('content_static_model','content_static');
        //$this->lang->load('news_static');
        $this->language = $this->lang->lang();
	}
	function index($page=0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/content_static/add';
        }
        //Xoa key khi search
        if($this->session->userdata('search')) {
            $this->session->unset_userdata('search');
        }
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'content_static/list';
        $this->load->view('templates', $data);
	}
    function search(){
        if($this->input->post()){
            $name = $this->input->post('name');
            if($name){
                $search['name'] = $name;
            }else{
                $search['name'] = "";
            }
            $this->session->set_userdata('search',$search);
        }else{
            $search['name'] = "";
            $this->session->unset_userdata('search');
        }
        $data['message'] = '';
        $data['status'] = true;
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
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
        //SEARCH
        $search = $this->session->userdata('search');
        //SEARCH
        $total = $this->content_static->getNumNewsStatic($search);
        $list = $this->content_static->getAllNewsStatic($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->code = $row->code;
                $data->title = $row->title;
                $data->dt_create = $row->dt_create;
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/content_static/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'content_static'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/content_static/del/").'"/>';
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
		$this->form_validation->set_rules('title','Name','trim|required');
		$this->form_validation->set_rules('content','Content','trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/content/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE; //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['img_news']['name'])&&$_FILES['img_news']['name']!=""){
    			if ($this->upload->do_upload('img_news')){	
    				$data_img = $this->upload->data();
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/content_static/add'));
    			}
    		}else {
    			$data_img['file_name'] = NULL;
    		}
            $DB['image'] = $data_img['file_name'];
            $DB['code'] = $this->input->post('code');
            $DB['title'] = $this->input->post('title');
            $DB['content'] = $this->input->post('content');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $DB['ordering'] = $this->input->post('ordering');
            $id = $this->content_static->saveNewsStatic($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect($this->module_name.'/content_static/index');
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
		}
		$data['title'] = lang('admin.add');
		$data['message'] = $this->message;
        $data['page'] = 'content_static/add';
        $this->load->view('templates', $data);
	}
	function edit($id,$page=0){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('code','Code','trim|required');
		$this->form_validation->set_rules('title','Name','trim|required');
		$this->form_validation->set_rules('content','Content','trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}
		else{
			$config['upload_path'] = $this->config->item('root')."uploads/content/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE; //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['img_news']['name'])&&$_FILES['img_news']['name']!=""){
    			if ($this->upload->do_upload('img_news')){	
    				$data_img = $this->upload->data();
                    $DB['image'] = $data_img['file_name'];
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/content_static/edit'.$id.'/'.$page));
    			}
    		}
            $DB['code'] = $this->input->post('code');
            $DB['title'] = $this->input->post('title');
            $DB['content'] = $this->input->post('content');
            $DB['dt_update'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = $this->input->post('bl_active');
            $DB['ordering'] = $this->input->post('ordering');
            $id = $this->content_static->saveNewsStatic($DB,$id);
			if($id){ 
				$this->session->set_flashdata('message',lang('save_success'));
				redirect(site_url($this->module_name.'/content_static/index/'.$page));
			}else{
                $this->message = lang('admin.save_unsuccessful');
            }
		}
		$data['item'] = $this->content_static->getNewsStaticByID($id);
		$data['title'] = lang('admin.edit').': '.$data['item']->title;
		$data['message'] = $this->message;
		$data['page'] = 'content_static/edit';
        $this->load->view('templates', $data);
	}
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->content_static->delete($id)){
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
                    if($this->content_static->delete($itemid[$i])){
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