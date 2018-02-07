<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Address extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('address_model','address');
        $this->load->model('city_model','city');
        $this->load->model('district_model','district');
        $this->load->model('ward_model','ward');
        $this->language = $this->lang->lang();
        $this->content->init($this->language);
    }   
    function index($page = 0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/address/add';
        }
        //Xoa key khi search
        $this->session->unset_userdata('content');
        $this->session->unset_userdata('district_id');
        $this->session->unset_userdata('ward_id');
        
        $config['base_url'] = base_url().$this->_module_name.'/address/index/';
        $data['num'] = $this->address->get_num_data();
        $config['total_rows'] = $data['num'];
        $config['per_page'] = 20;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->address->get_all_data($config['per_page'],(int)$current_page);
        $data['pagination'] = $this->pagination->create_links();
        $data['current_page'] = $current_page;
        $data['title'] = lang('city.list');
        $data['category'] = $this->city->get_all_data();
        
        $this->_templates['page'] = 'address/list';
        $this->site_library->load($this->_templates['page'],$data);
    }
    
    function search(){
                
    }
    
    function add(){    
    	$this->check->check('add','','',base_url());

        $this->form_validation->set_rules('city_id',"Tỉnh thành",'trim|required');
        $this->form_validation->set_rules('district_id',"Quận huyện",'trim|required');
        $this->form_validation->set_rules('ward_id',"Phường xã",'trim|required');
        $this->form_validation->set_rules('address',"Địa chỉ",'trim|required');
        $this->form_validation->set_rules('phone',"Điện thoại",'trim|required');
        $this->form_validation->set_rules('timeopen',"Giờ mở cửa",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->pre_message = validation_errors();
		}else{
            $DB['city_id'] = $this->input->post('city_id');
            $DB['district_id'] = $this->input->post('district_id');
            $DB['ward_id'] = $this->input->post('ward_id');
            $DB['address'] = $this->input->post('address');
            $DB['phone'] = $this->input->post('phone');
            $DB['timeopen'] = $this->input->post('timeopen');
            $DB['lat'] = $this->input->post('lat');
            $DB['lng'] = $this->input->post('lng');
            $DB['bl_active'] = $this->input->post('bl_active');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $id = $this->address->save_data($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('save_success'));
                redirect($this->_module_name.'/address/index');
            }
        }
        
        $data['title'] = lang('city.add');
        $data['category'] = $this->city->get_all_data();
		$data['message'] = $this->pre_message;
		$this->_templates['page'] = 'address/add';
		$this->site_library->load($this->_templates['page'],$data);
    }
    
    function edit($id,$current_page = 0){     
    	$this->check->check('edit','','',base_url());
        $this->form_validation->set_rules('city_id',"Tỉnh thành",'trim|required');
        $this->form_validation->set_rules('district_id',"Quận huyện",'trim|required');
        $this->form_validation->set_rules('ward_id',"Phường xã",'trim|required');
        $this->form_validation->set_rules('address',"Địa chỉ",'trim|required');
        $this->form_validation->set_rules('phone',"Điện thoại",'trim|required');
        $this->form_validation->set_rules('timeopen',"Giờ mở cửa",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->pre_message = validation_errors();
		}else{
            $DB['city_id'] = $this->input->post('city_id');
            $DB['district_id'] = $this->input->post('district_id');
            $DB['ward_id'] = $this->input->post('ward_id');
            $DB['address'] = $this->input->post('address');
            $DB['phone'] = $this->input->post('phone');
            $DB['timeopen'] = $this->input->post('timeopen');
            $DB['lat'] = $this->input->post('lat');
            $DB['lng'] = $this->input->post('lng');
            $DB['bl_active'] = $this->input->post('bl_active');
            //$DB['dt_create'] = date('Y-m-d H:i:s');
            $id = $this->address->save_data($DB,$id);
            if($id){                  
                $this->session->set_flashdata('message',lang('save_success'));
                redirect($this->_module_name.'/address/index');
            }
        }
        
        $data['category'] = $this->city->get_all_data();
        $data['rs'] = $this->address->get_item_data($id);
        $data['title'] = lang('city.edit');
        
        $data['message'] = $this->pre_message;
		$this->_templates['page'] = 'address/edit';
		$this->site_library->load($this->_templates['page'],$data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->address->delete_data($id)){
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
                    if($this->address->delete_data($itemid[$i])){
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
        $data['category'] = $this->district->get_item_city($id);
        $this->load->view('address/ajax_district', $data);
    }
    function ward(){
        $id = $this->input->post('id');
        $data['category'] = $this->ward->get_item_district($id);
        $this->load->view('address/ajax_ward', $data);
    }
}
/* End of file address.php */
/* Location: ./system/application/controllers/welcome.php */