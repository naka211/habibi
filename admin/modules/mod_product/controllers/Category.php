<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Category extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('category_model','category');
        //$this->lang->load('product');
        $this->language = $this->lang->lang();
    }

    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/category/add';
        }
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'category/list';
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
        $total = $this->category->get_num_category($search);
        $list = $this->category->get_all_category($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->category_id = $row->category_id;
                $data->name = $row->name;
                if($row->image){
                    $data->image = '<img src="'.base_url_site()."uploads/product/".$row->image.'" width="150" />';
                }else{
                    $data->image = '';
                }
                $data->description = $row->description;
                $data->dt_create = $row->dt_create;
                $data->sort = icon_sort($row->category_id,$row->ordering);
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/category/edit/'.$row->category_id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->category_id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'product_category'","'category_id'",$row->category_id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->category_id.'" name="linkDelete-'.$row->category_id.'" value="'.site_url($this->module_name."/category/del/").'"/>';
                    $data->action .= icon_delete($row->category_id);
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
		$this->form_validation->set_rules('name',"Name",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/product/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['image']['name'])&&$_FILES['image']['name']!=""){
    			if ($this->upload->do_upload('image')){	
    				$data_img = $this->upload->data();
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/category/add'));
    			}
    		}else {
    			$data_img['file_name'] = NULL;
    		}
            if(isset($_FILES['images']['name'])&&$_FILES['images']['name']!=""){
    			if ($this->upload->do_upload('images')){	
    				$data_imgs = $this->upload->data();
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/category/add'));
    			}
    		}else {
    			$data_imgs['file_name'] = NULL;
    		}
            $DB['image'] = $data_img['file_name'];
            $DB['images'] = $data_imgs['file_name'];
            $DB['name'] = $this->input->post('name');
            $DB['description'] = $this->input->post('description');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $id = $this->category->save_category($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/category/index'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['title'] = lang('category.add');
        $data['message'] = $this->message;
        $data['page'] = 'category/add';
        $this->load->view('templates', $data);
	}
    function edit($id,$page = 0){
        $this->check->check('edit','','',base_url());
		$this->form_validation->set_rules('name',"Name",'trim|required');
        if($this->form_validation->run()== FALSE){
            $this->message = validation_errors();
        }else{
            $config['upload_path'] = $this->config->item('root')."uploads/product/";
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
                    redirect(site_url($this->module_name.'/category/edit/'.$id.'/'.$page));
    			}
    		}
            if(isset($_FILES['images']['name'])&&$_FILES['images']['name']!=""){
    			if ($this->upload->do_upload('images')){	
    				$data_imgs = $this->upload->data();
                    $DB['images'] = $data_imgs['file_name'];
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/category/edit/'.$id.'/'.$page));
    			}
    		}
            $DB['name'] = $this->input->post('name');
            $DB['description'] = $this->input->post('description');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['dt_update'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = $this->input->post('bl_active');
            $id = $this->category->save_category($DB,$id);
            if($id){
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/category/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->category->get_item_category($id);
        $data['title'] = lang('admin.edit').': '.$data['item']->name;
        $data['message'] = $this->message;
        $data['page'] = 'category/edit';
        $this->load->view('templates', $data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->category->delete_category($id)){
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
                    if($this->category->delete_category($itemid[$i])){
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