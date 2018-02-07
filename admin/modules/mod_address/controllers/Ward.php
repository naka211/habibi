<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Ward extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('city_model','city');
        $this->load->model('district_model','district');
        $this->load->model('ward_model','ward');
        $this->language = $this->lang->lang();
        $this->district->init($this->language);
    }   
    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/ward/add';
        }
        //Xoa key khi search
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['city'] = $this->city->getAllCity();
        $data['title'] = lang('admin.list');
        $data['page'] = 'ward/list';
        $this->load->view('templates', $data);
    }
    function search(){
    
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
        $total = $this->ward->getNumData($search);
        $list = $this->ward->getAllWard($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->ward_id = $row->ward_id;
                $data->name = $row->name;
                $data->type_district = $row->type_district;
                $data->city = $row->city;
                $data->sort = icon_sort($row->ward_id,$row->ordering);
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/ward/edit/'.$row->ward_id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->ward_id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'city_ward'","'ward_id'",$row->ward_id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->ward_id.'" name="linkDelete-'.$row->ward_id.'" value="'.site_url($this->module_name."/ward/del/").'"/>';
                    $data->action .= icon_delete($row->ward_id);
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
    	$this->acl->check('add','','',base_url());

        $this->form_validation->set_rules('city_id',"Tỉnh thành",'trim|required');
        $this->form_validation->set_rules('district_id',"Quận huyện",'trim|required');
        $this->form_validation->set_rules('name',"Tên",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->pre_message = validation_errors();
		}else{
            $DB['city_id'] = $this->input->post('city_id');
            $DB['district_id'] = $this->input->post('district_id');
            $DB['name'] = $this->input->post('name');
            $DB['bl_active'] = $this->input->post('bl_active');
            $id = $this->ward->save_data($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('save_success'));
                redirect($this->_module_name.'/ward/index');
            }
        }
        
        $data['title'] = lang('city.add');
        $data['category'] = $this->city->get_all_data();
		$data['message'] = $this->pre_message;
		$this->_templates['page'] = 'ward/add';
		$this->site_library->load($this->_templates['page'],$data);
    }
    
    function edit($id,$page = 0){     
    	$this->acl->check('edit','','',base_url());
        $this->form_validation->set_rules('city_id',"Tỉnh thành",'trim|required');
        $this->form_validation->set_rules('district_id',"Quận huyện",'trim|required');
        $this->form_validation->set_rules('name',"Tên",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->pre_message = validation_errors();
		}else{
            $DB['city_id'] = $this->input->post('city_id');
            $DB['district_id'] = $this->input->post('district_id');
            $DB['name'] = $this->input->post('name');
            $DB['bl_active'] = $this->input->post('bl_active');
            $id = $this->ward->save_data($DB,$id);
            if($id){                  
                $this->session->set_flashdata('message',lang('save_success'));
                redirect($this->_module_name.'/ward/index/'.$current_page);
            }
        }
        
        $data['category'] = $this->city->get_all_data();
        $data['rs'] = $this->ward->get_item_data($id);
        
        //Get cityID
        $district = $this->district->get_item_data($data['rs']->district_id);
        $data['city_id'] = $district->city_id;
        
        $data['district'] = $this->district->get_item_city($district->city_id);
        
        $data['title'] = lang('city.edit');
        
        $data['message'] = $this->pre_message;
		$this->_templates['page'] = 'ward/edit';
		$this->site_library->load($this->_templates['page'],$data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->ward->delete_data($id)){
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
                    if($this->ward->delete_data($itemid[$i])){
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
    /** More function*/
    function district(){
        $id = $this->input->post('id');
        $data['category'] = $this->district->get_item_by_city($id);
        $this->load->view('ward/ajax_district', $data);
    }
}
/* End of file ward.php */
/* Location: ./system/application/controllers/welcome.php */