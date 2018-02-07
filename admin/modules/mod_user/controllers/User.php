<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller{
    public $module_name = "";
    private $message = "";
    public $language = "";
    function __construct(){
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('user_model','user');
        //$this->lang->load('user');
        $this->language = $this->lang->lang();
    }

    function index($page=0){
        $this->check->check('view','','',base_url());
        if($this->check->check('add')){
            $data['add'] = $this->module_name.'/user/add';
        }
        if($this->check->check('export')){
            $data['export'] = $this->module_name.'/user/export';
        }
        $this->session->unset_userdata('search');
        if($page > 0){
            $this->session->set_userdata('offset',$page);
        }else{
            $this->session->unset_userdata('offset');
        }
        $data['title'] = lang('admin.list');
        $data['page'] = 'user/list';
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
        $total = $this->user->get_num_data($search);
        $list = $this->user->get_all_data($limit,$offset,$search);
        if($list){
            foreach($list as $row){
                $data = new stdClass();
                $data->id = $row->id;
                $data->name = $row->name;
                if($row->avatar){ if($row->facebook){
                    $data->avatar = '<img src="'.$row->avatar.'" width="150" />';
                }else{
                    $data->avatar = '<img src="'.base_url_site()."uploads/user/".$row->avatar.'" width="150" />';
                }}else{
                    $data->avatar = '';
                }
                $data->birthday = $row->birthday;
                if($row->groups == 3){
                    $data->type = "Google";
                }else if($row->groups == 2){
                    $data->type = "Facebook";
                }else{
                    $data->type = "Register";
                }
                if($row->type == 2){
                    $data->membership = "Gold";
                }else{
                    $data->membership = "Silver";
                }
                $data->dt_create = $row->dt_create;
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit'))?icon_edit($this->module_name.'/user/edit/'.$row->id.'/'.$offset):"";
                $data->action .= '<span id="publish'.$row->id.'">';
                $data->action .= ($this->check->check('edit'))?icon_active("'user'","'id'",$row->id,$row->bl_active):"";
                $data->action .= '</span>';
                if($this->check->check('del')){
                    $data->action .= '<input type="hidden" id="linkDelete-'.$row->id.'" name="linkDelete-'.$row->id.'" value="'.site_url($this->module_name."/user/del/").'"/>';
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
		$this->form_validation->set_rules('name',"Name",'trim|required');
        $this->form_validation->set_rules('email',"Email",'trim|required|valid_email');
        if($this->input->post('password')){
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passwordconfirm]');
            $this->form_validation->set_rules('passwordconfirm', 'Password confirmation', 'trim|required');
        }
        $this->form_validation->set_rules('birthday',"Birthday",'trim|required');
        $this->form_validation->set_rules('gender',"Gender",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/user/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['avatar']['name'])&&$_FILES['avatar']['name']!=""){
    			if ($this->upload->do_upload('avatar')){	
    				$data_img = $this->upload->data();
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/user/add'));
    			}
    		}else {
    			$data_img['file_name'] = NULL;
    		}
            $DB['avatar'] = $data_img['file_name'];
            $DB['name'] = $this->input->post('name');
            $DB['email'] = $this->input->post('email');
            if($this->input->post('password')){
                $DB['password'] = md5($this->input->post('password'));
            }
            $birthday = explode("/", $this->input->post('birthday'));
            $DB['day'] = $birthday[0];
            $DB['month'] = $birthday[1];
            $DB['year'] = $birthday[2];
            $DB['birthday'] = $this->input->post('birthday');
            $DB['gender'] = $this->input->post('gender');
            $DB['type'] = $this->input->post('type');
            $DB['code'] = $this->input->post('code');
            $DB['city'] = $this->input->post('city');
            $DB['description'] = $this->input->post('description');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $id = $this->user->save_data($DB);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/user/index'));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['title'] = lang('admin.add');
        $data['message'] = $this->message;
        $data['page'] = 'user/add';
        $this->load->view('templates', $data);
    }
    function edit($id,$page = 0){
        $this->check->check('add','','',base_url());
		$this->form_validation->set_rules('name',"Name",'trim|required');
        $this->form_validation->set_rules('email',"Email",'trim|required|valid_email');
        if($this->input->post('password')){
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passwordconfirm]');
            $this->form_validation->set_rules('passwordconfirm', 'Password confirmation', 'trim|required');
        }
        $this->form_validation->set_rules('birthday',"Birthday",'trim|required');
        $this->form_validation->set_rules('gender',"Gender",'trim|required');
		if($this->form_validation->run()== FALSE){
			$this->message = validation_errors();
		}else{
            $config['upload_path'] = $this->config->item('root')."uploads/user/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
    		if(isset($_FILES['avatar']['name'])&&$_FILES['avatar']['name']!=""){
    			if ($this->upload->do_upload('avatar')){	
    				$data_img = $this->upload->data();
                    $DB['avatar'] = $data_img['file_name'];
    			} else {
    				$this->session->set_flashdata('message',"Upload image failed");
                    redirect(site_url($this->module_name.'/user/edit/'.$id.'/'.$page));
    			}
    		}
            $DB['name'] = $this->input->post('name');
            $DB['email'] = $this->input->post('email');
            if($this->input->post('password')){
                $DB['password'] = md5($this->input->post('password'));
            }
            $birthday = explode("/", $this->input->post('birthday'));
            $DB['day'] = $birthday[0];
            $DB['month'] = $birthday[1];
            $DB['year'] = $birthday[2];
            $DB['birthday'] = $this->input->post('birthday');
            $DB['gender'] = $this->input->post('gender');
            $DB['type'] = $this->input->post('type');
            $DB['code'] = $this->input->post('code');
            $DB['city'] = $this->input->post('city');
            $DB['description'] = $this->input->post('description');
            $DB['dt_update'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = $this->input->post('bl_active');;
            $id = $this->user->save_data($DB,$id);
            if($id){                  
                $this->session->set_flashdata('message',lang('admin.save_successful'));
                redirect(site_url($this->module_name.'/user/index/'.$page));
            }else{
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['item'] = $this->user->get_item_data($id);
        $data['title'] = lang('admin.edit');
        $data['message'] = $this->message;
        $data['page'] = 'user/edit';
        $this->load->view('templates', $data);
    }
    function del(){
        $check = $this->check->check('del','','');
        if($check){
            $id = $this->input->post('id',true);
            if($this->user->delete_data($id)){
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
                    if($this->user->delete_data($itemid[$i])){
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
    function export(){
        $this->check->check('export','','',base_url());
        $data['title'] = 'Xuất thông tin thành viên';
        $this->form_validation->set_rules('tungay','Ngày bắt đầu','required');
        $this->form_validation->set_rules('denngay','Ngày kết thúc','required');
        if($this->form_validation->run() == false){
            $this->pre_message = validation_errors();
        }else{
            $from = $this->input->post('tungay')." 00:00:00";
            $to = $this->input->post('denngay')." 23:59:59";
            $list = $this->member->export_user($from,$to);
            ini_set('memory_limit', '10000M');
            memory_get_peak_usage(true);
            require $this->config->item('phpexcel').'PHPExcel.php';
            // Create new PHPExcel object
            $this->phpexcel = new PHPExcel();
            $this->phpexcel->getProperties()->setCreator("Viet Tien Phong Advertising Company Ltd.")
							 ->setLastModifiedBy("Viet Tien Phong Advertising Company Ltd.")
							 ->setTitle("Thong Ke")
							 ->setSubject("Thong Ke")
							 ->setDescription("File Thong Ke. Author: VietBuzzAD.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Thong Ke");
            // Set properties
            $this->phpexcel->getDefaultStyle()->getFont()->setName('Arial');
            $this->phpexcel->getDefaultStyle()->getFont()->setSize(13);
            // SET HEADER FILE EXCEL
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'Danh sách thành viên từ: '.date("d/m/Y",strtotime($this->input->post('tungay'))).' đến ngày '.date("d/m/Y",strtotime($this->input->post('denngay'))));
            //STT
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A3', 'STT');
            $this->phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('B3', 'Tên');
            $this->phpexcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('C3', 'Link Video');
            $this->phpexcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('D3', 'Tuần');
            $this->phpexcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            /*//
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('E3', 'Tỉnh/Thành');
            $this->phpexcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('F3', 'Thiết bị');
            $this->phpexcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('G3', 'Landing Page');
            $this->phpexcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('H3', 'Nguồn');
            $this->phpexcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('I3', 'UTM Medium');
            $this->phpexcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('J3', 'UTM Term');
            $this->phpexcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('K3', 'UTM Content');
            $this->phpexcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('L3', 'UTM Campaign');
            $this->phpexcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('M3', 'Verify');
            $this->phpexcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
            //
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('N3', 'Ngày Đăng Ký');
            $this->phpexcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('O3', 'Ngày Verify');
            $this->phpexcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('P3', 'Ngày Phản Hồi');
            $this->phpexcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
            
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('Q3', 'Loại Phản Hồi');
            $this->phpexcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
            */
            $i=4;
            foreach($list as $key=>$rs):
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $key+1);
                
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $rs->name);
                
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $rs->avatar);
                
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $rs->password);
                /*
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $rs->province);
                
                if($rs->mobile == 1){
                    $mobile = 'Mobile';
                }else{
                    $mobile = 'PC';
                }
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $mobile);
                
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $rs->landingpage);
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('H'.$i, $rs->source);
                if($rs->medium == 'null'){
                    $medium = "";
                }else{
                    $medium = $rs->medium;
                }
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('I'.$i, $medium);
                if($rs->term == 'null'){
                    $term = "";
                }else{
                    $term = $rs->term;
                }
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('J'.$i, $term);
                if($rs->content == 'null'){
                    $content = "";
                }else{
                    $content = $rs->content;
                }
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('K'.$i, $content);
                if($rs->campaign == 'null'){
                    $campaign = "";
                }else{
                    $campaign = $rs->campaign;
                }
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('L'.$i, $campaign);
                if($rs->bl_active == 1){
                    $verify = 'Yes';
                }else{
                    $verify = 'NO';
                }
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('M'.$i, $verify);
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('N'.$i, $rs->dt_create);
                
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('O'.$i, $rs->login);
                
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('P'.$i, $rs->confirm);
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('Q'.$i, $rs->facebook_id);
                */
                $i++;
            endforeach;
            //set Font
            $this->phpexcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->phpexcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
            // Witdh
            $this->phpexcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $this->phpexcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Tahoma');
            $this->phpexcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
            $this->phpexcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Tahoma');
            $this->phpexcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            // Rename sheet
            $this->phpexcel->getActiveSheet()->setTitle('Thongke');
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $this->phpexcel->setActiveSheetIndex(0);
            
            $date = date('H_i_s_d_m_Y',time());
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            #header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="thanh_vien_'.$date.'.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 2020 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter( $this->phpexcel, 'Excel5');
            #$objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'member/export';
        $this->site_library->load($this->_templates['page'],$data);
    }
}
?>