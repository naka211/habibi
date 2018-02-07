<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Banner extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('banner_model','banner');
        $this->load->model('category_model','category');
        //$this->lang->load('banner');
        $this->language = $this->lang->lang();
    }

    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/banner/add';
        }
        //Xoa key khi search
        //Xoa key khi search
        if($this->session->userdata('search')){
            $this->session->unset_userdata('search');
        }
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['category'] = $this->category->get_all_category();
        $data['title'] = lang('admin.list');
        $data['page'] = 'banner/list';
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
        $total = $this->banner->get_num_data($search);
        $list = $this->banner->get_all_data($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->name = $row->name;
                if($row->image){
                    $data->image = '<img src="'.base_url_site()."uploads/banner/".$row->image.'" width="150" />';
                }else{
                    $data->image = "";
                }
                $data->link = '<a href="'.$row->link.'" target="_blank">'.$row->link.'</a>';
                $data->namecategory = $row->namecategory;
                $data->dt_create = $row->dt_create;
                $data->sort = icon_sort($row->id,$row->ordering);
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/banner/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'banner_banner'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/banner/del/").'"/>';
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
        $this->form_validation->set_rules('category_id',"Category",'trim|required');
        $this->form_validation->set_rules('name',"Name",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/banner/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=""){
    			if ($this->upload->do_upload('image')){	
    				$data_img = $this->upload->data();
    			}else{
    			    //var_dump($this->upload->error_msg);exit();
    				$this->session->set_flashdata('error',"Upload image failed");
                    redirect(site_url($this->module_name.'/banner/add'));
    			}
    		}else {
    			$data_img['file_name'] = NULL;
    		}
            $DB['image'] = $data_img['file_name'];
            $DB['category_id'] = $this->input->post('category_id');
            $DB['name'] = $this->input->post('name');
            $DB['description'] = $this->input->post('description');
            $DB['content'] = $this->input->post('content');
            $DB['link'] = $this->input->post('link');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $id = $this->banner->save_data($DB);
            if($id){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/banner/index'));
            }else{
                $this->session->set_flashdata('error',lang('admin.save_unsuccessful'));
                redirect(site_url($this->module_name.'/banner/add'));
            }
        }
        $data['title'] = lang('admin.add');
        $data['category'] = $this->category->get_all_category();
		$data['message'] = $this->message;
		$data['page'] = 'banner/add';
        $this->load->view('templates', $data);
	}
    function edit($id,$page = 0){
        $this->check->check('add','','',base_url());
        $this->form_validation->set_rules('category_id',"Category",'trim|required');
        $this->form_validation->set_rules('name',"Name",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/banner/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=""){
    			if ($this->upload->do_upload('image')){	
    				$data_img = $this->upload->data();
                    $DB['image'] = $data_img['file_name'];
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/banner/edit/'.$id.'/'.$page));
    			}
    		}
            $DB['category_id'] = $this->input->post('category_id');
            $DB['name'] = $this->input->post('name');
            $DB['description'] = $this->input->post('description');
            $DB['content'] = $this->input->post('content');
            $DB['link'] = $this->input->post('link');
            $DB['dt_update'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = $this->input->post('bl_active');
            $id = $this->banner->save_data($DB,$id);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/banner/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->banner->get_item($id);
        $data['title'] = lang('admin.edit').": ".$data['item']->name;
		$data['category'] = $this->category->get_all_category();
		$data['message'] = $this->message;
        $data['page'] = 'banner/edit';
        $this->load->view('templates', $data);
	}
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->banner->delete_data($id)){
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
                    if($this->banner->delete_data($itemid[$i])){
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