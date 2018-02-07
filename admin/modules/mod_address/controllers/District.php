<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class District extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('district_model','district');
        $this->load->model('city_model','city');
        //$this->lang->load('city');
        $this->language = $this->lang->lang();
        $this->district->init($this->language);
    }   
    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/district/add';
        }
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['city'] = $this->city->getAllCity();
        $data['title'] = lang('admin.list');
        $data['page'] = 'district/list';
        $this->load->view('templates', $data);
    }
    function search(){
        if($this->input->post()){
            $name = $this->input->post('name');
            $city_id = $this->input->post('city_id');
            if($name){
                $search['name'] = $name;
            }else{
                $search['name'] = "";
            }
            if($city_id){
                $search['city_id'] = $city_id;
            }else{
                $search['city_id'] = "";
            }
            $this->session->set_userdata('search',$search);
        }else{
            $search['name'] = "";
            $search['city_id'] = "";
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
        $total = $this->district->getNumData($search);
        $list = $this->district->getAllDistrict($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->district_id = $row->district_id;
                $data->name = $row->name;
                $data->type_district = $row->type_district;
                $data->city = $row->city;
                $data->sort = icon_sort($row->district_id,$row->ordering);
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/district/edit/'.$row->district_id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->district_id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'city_district'","'district_id'",$row->district_id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->district_id.'" name="linkDelete-'.$row->district_id.'" value="'.site_url($this->module_name."/district/del/").'"/>';
                    $data->action .= icon_delete($row->district_id);
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
        $this->form_validation->set_rules('city_id',"Tỉnh/Thành",'trim|required');
        $this->form_validation->set_rules('name',"Tên",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $DB['city_id'] = $this->input->post('city_id');
            $DB['type_district'] = $this->input->post('type_district');
            $DB['name'] = $this->input->post('name');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['bl_active'] = 1;
            $id = $this->district->save_data($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/district/index'));
            }
        }
        $data['city'] = $this->city->getAllCity();
		$data['message'] = $this->message;
        $data['title'] = lang('city.add');
        $data['page'] = 'district/add';
		$this->load->view('templates',$data);
    }
    
    function edit($id,$page = 0){
    	$this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('city_id',"Tỉnh/Thành",'trim|required');
        $this->form_validation->set_rules('name',"Tên",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $DB['city_id'] = $this->input->post('city_id');
            $DB['name'] = $this->input->post('name');
            $DB['type_district'] = $this->input->post('type_district');
            $DB['ordering'] = $this->input->post('ordering');
            $DB['bl_active'] = $this->input->post('bl_active');
            $id = $this->district->save_data($DB,$id);
            if($id){
                $this->session->set_flashdata('message',lang('save_success'));
                redirect(site_url($this->module_name.'/district/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['city'] = $this->city->getAllCity();
        $data['item'] = $this->district->get_item_data($id);
        $data['title'] = lang('city.edit').": ".$data['item']->name;
        $data['message'] = $this->message;
        $data['page'] = 'district/edit';
		$this->load->view('templates',$data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->district->delete_data($id)){
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
                    if($this->district->delete_data($itemid[$i])){
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
/* End of file district.php */
/* Location: ./system/application/controllers/welcome.php */