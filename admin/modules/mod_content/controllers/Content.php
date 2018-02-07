<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Content extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('content_model','content');
        $this->lang->load('content');
        $this->language = $this->lang->lang();
        $this->content->init($this->language);
    }

    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/content/add';
        }
        if($this->check->check('exp')){
            //$data['export'] = $this->module_name.'/content/export';
        }
        //Xoa key khi search
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['category'] = $this->content->getCategoryParentName();
        $data['title'] = lang('admin.list');
        $data['page'] = 'content/list';
        $this->load->view('templates', $data);
    }
    function search(){
        if($this->input->post()){
            $name = $this->input->post('name');
            $category_id = $this->input->post('category_id');
            if($name){
                $search['name'] = $name;
            }else{
                $search['name'] = "";
            }
            if($category_id){
                $search['category_id'] = $category_id;
            }else{
                $search['category_id'] = "";
            }
            $this->session->set_userdata('search',$search);
        }else{
            $search['name'] = "";
            $search['category_id'] = "";
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
        $total = $this->content->getNumContent($search);
        $list = $this->content->getAllContent($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->title = $row->title;
                if($row->image){
                    $data->image = '<img src="'.base_url_site()."uploads/content/".$row->image.'" width="150" />';
                }else{
                    $data->image = "";
                }
                $data->description = $row->description;
                $data->category = $row->nameCategory;
                $data->dt_create = $row->dt_create;
                $data->sort = icon_sort($row->id,$row->ordering);
                //ACTION
                $data->action = "";
                $data->action .= icon_view_popup($this->module_name.'/content/more/',$row->id);
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/content/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'content_content'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/content/del/").'"/>';
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
        $this->form_validation->set_rules('title',lang('content.name'),'trim|required');
        $this->form_validation->set_rules('content',lang('content.content'),'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/content/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['img_content']['name'])&&$_FILES['img_content']['name']!=""){
    			if ($this->upload->do_upload('img_content')){	
    				$data_img = $this->upload->data();
    			}else {
    				$this->session->set_flashdata('message',"upload image failed");
                    redirect(site_url($this->module_name.'/content/add'));
    			}
    		}else {
    			$data_img['file_name'] = NULL;
    		}
            $DB['image'] = $data_img['file_name'];
            $DB['category_id'] = $this->input->post('category_id');
            $DB['title'] = $this->input->post('title');
            $DB['description'] = $this->input->post('description');
            $DB['content'] = $this->input->post('content');
            $DB['bl_active'] = 1;
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['ordering'] = $this->input->post('ordering');
            $id = $this->content->save_content($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/content/index'));
            }
        }
        $data['category'] = $this->content->getCategoryParentName();
        $data['title'] = lang('admin.add');
		$data['message'] = $this->message;
		$data['page'] = 'content/add';
		$this->load->view('templates',$data);
	}
    function edit($id,$page = 0){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('title',lang('content.name'),'trim|required');
        $this->form_validation->set_rules('content',lang('content.content'),'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/content/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['img_content']['name'])&&$_FILES['img_content']['name']!=""){
    			if ($this->upload->do_upload('img_content')){	
    				$data_img = $this->upload->data();
                    $DB['image'] = $data_img['file_name'];
    			} else {
    				$this->session->set_flashdata('message',"upload image failed");
                    redirect(site_url($this->module_name.'/content/edit/'.$id.'/'.$page));
    			}
    		}
            $DB['category_id'] = $this->input->post('category_id');
            $DB['title'] = $this->input->post('title');
            $DB['description'] = $this->input->post('description');
            $DB['content'] = $this->input->post('content');
            $DB['dt_update'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = $this->input->post('bl_active');
            $DB['ordering'] = $this->input->post('ordering');
            $id = $this->content->save_content($DB,$id);
            if($id){                  
                $this->session->set_flashdata('message',lang('save_success'));
                redirect(site_url($this->module_name.'/content/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->content->get_content($id);
        $data['category'] = $this->content->getCategoryParentName();
        $data['title'] = lang('admin.edit').": ".$data['item']->title;
		$data['message'] = $this->message;
		$data['page'] = 'content/edit';
		$this->load->view('templates',$data);
	}

    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->content->delete_content($id)){
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
                    if($this->content->delete_content($itemid[$i])){
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