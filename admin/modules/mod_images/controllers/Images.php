<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Images extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
	function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('images_model','images');
        //$this->lang->load('news_static');
        $this->language = $this->lang->lang();
	}
	function index($page=0){
        $this->check->check('view','','',base_url());
        if($this->input->get('name') || $this->input->get('status')){
            $search['name'] = $this->input->get('name');
            $search['status'] = $this->input->get('status');
            $this->session->set_userdata('search',$search);
        } else {
            $this->session->unset_userdata('search');
        }

        $data['search'] = $this->session->userdata('search');
        $data['title'] = lang('admin.list');
        $data['page'] = 'images/list';
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
        //SEARCH
        $search = $this->session->userdata('search');
        //SEARCH
        $total = $this->images->getNumImages($search);
        $list = $this->images->getAllImages($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->name = $row->name;
                $data->image = '<img src="'.base_url_site().'uploads/thumb_photo/'.$row->image.'" width="150" \>';;
                $data->dt_create = date("d.m.Y K\l.H:i", $row->dt_create);
                //ACTION
                $data->action = "";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'user_image'","'id'",$row->id,$row->status):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/images/del/").'"/>';
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

    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            $image = $this->images->getImageName($id);
            unlink($this->config->item('root')."uploads".DIRECTORY_SEPARATOR."photo".DIRECTORY_SEPARATOR.$image->image);
            unlink($this->config->item('root')."uploads".DIRECTORY_SEPARATOR."thumb_photo".DIRECTORY_SEPARATOR.$image->image);
            if($this->images->delete($id)){
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
                    $image = $this->images->getImageName($itemid[$i]);
                    unlink($this->config->item('root')."uploads".DIRECTORY_SEPARATOR."photo".DIRECTORY_SEPARATOR.$image->image);
                    unlink($this->config->item('root')."uploads".DIRECTORY_SEPARATOR."thumb_photo".DIRECTORY_SEPARATOR.$image->image);
                    if($this->images->delete($itemid[$i])){
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