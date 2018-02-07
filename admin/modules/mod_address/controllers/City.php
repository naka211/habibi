<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class City extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
	function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('Url'=>uri_string()));
        //$this->lang->load('city');
		$this->load->model('city_model','city');
        $this->language = $this->lang->lang();
        $this->city->init($this->language);
	}

	function index($page=0){
		$this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/city/add';
        }
        //Xoa key khi search
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
		$data['page'] = 'city/list';
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
        $total = $this->city->getNumData($search);
        $list = $this->city->getAllCity($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->city_id = $row->city_id;
                $data->name = $row->name;
                $data->type_province = $row->type_province;
                $data->sort = icon_sort($row->city_id,$row->ordering);
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/city/edit/'.$row->city_id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->city_id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'city_province'","'city_id'",$row->city_id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->city_id.'" name="linkDelete-'.$row->city_id.'" value="'.site_url($this->module_name."/city/del/").'"/>';
                    $data->action .= icon_delete($row->city_id);
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
        $this->form_validation->set_rules('name','Tên','trim|required');
        if($this->form_validation->run()== FALSE){
            $this->message = validation_errors();
        }else{
            $DB['name'] = $this->input->post('name');
            $DB['type_province'] = $this->input->post('type_province');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['bl_active'] = 1;
            $id = $this->city->saveCity($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/city/index'));
            }
        }
        $data['title'] = lang('admin.add');
		$data['message'] = $this->message;
		$data['page'] = 'city/add';
		$this->load->view('templates',$data);
	}
	function edit($id,$page = 0){
        $this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('name','Tên','trim|required');
        if($this->form_validation->run()== FALSE){
            $this->message = validation_errors();
        }else{
            $DB['name'] = $this->input->post('name');
            $DB['type_province'] = $this->input->post('type_province');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['bl_active'] = $this->input->post('bl_active');
            $id = $this->city->saveCity($DB,$id);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/city/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->city->getCity($id);
        $data['title'] = lang('admin.edit').": ".$data['item']->name;
		$data['message'] = $this->message;
		$data['page'] = 'city/edit';
		$this->load->view('templates',$data);
	}
	function del(){
	   $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->city->deleteCity($id)){
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
                    if($this->city->deleteCity($itemid[$i])){
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
/* End of file city.php */
/* Location: ./system/application/controllers/welcome.php */