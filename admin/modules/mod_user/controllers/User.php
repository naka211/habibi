<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
    public $module_name = "";
    private $message = "";
    public $language = "";

    function __construct()
    {
        parent::__construct();
        $this->module_name = $this->router->fetch_module();
        $this->session->set_userdata(array('url' => uri_string()));
        $this->load->model('user_model', 'user');
        //$this->lang->load('user');
        $this->language = $this->lang->lang();
    }

    function index($page = 0)
    {
        $this->check->check('view', '', '', base_url());
        if ($this->check->check('add')) {
            $data['add'] = $this->module_name . '/user/add';
        }
        if ($this->check->check('export')) {
            $data['export'] = $this->module_name . '/user/export';
        }

        if ($this->input->get('name')) {
            $search['name'] = $this->input->get('name');
            $this->session->set_userdata('search', $search);
        } else {
            $this->session->unset_userdata('search');
        }

        if ($page > 0) {
            $this->session->set_userdata('offset', $page);
        } else {
            $this->session->unset_userdata('offset');
        }

        $data['search'] = $this->session->userdata('search');
        $data['title'] = lang('admin.list');
        $data['page'] = 'user/list';
        $this->load->view('templates', $data);
    }

    function search()
    {
        if ($this->input->post()) {
            $name = $this->input->post('name');
            if ($name) {
                $search['name'] = $name;
            } else {
                $search['name'] = "";
            }
            $this->session->set_userdata('search', $search);
        } else {
            $search['name'] = "";
            $this->session->unset_userdata('search');
        }
        $data['message'] = '';
        $data['status'] = true;
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function getContent()
    {
        if($_GET['limit'] != 10){
            $limit = $_GET['limit'];
            $this->session->set_userdata('limit', $limit);
        } else {
            if($this->session->userdata('limit')){
                $limit = $this->session->userdata('limit');
            } else {
                $limit = 10;
            }
        }

        if ($this->session->userdata('offset')) {
            $offset = $this->session->userdata('offset');
        } else {
            $offset = $this->input->get('offset');
        }
        //SEARCH
        $search = $this->session->userdata('search');
        //SEARCH
        $total = $this->user->get_num_data($search);
        $list = $this->user->get_all_data($limit, $offset, $search);
        if ($list) {
            foreach ($list as $row) {
                $data = new stdClass();
                $data->id = $row->id;
                $data->name = $row->name;
                if ($row->new_avatar) {
                    $data->avatar = '<img src="' . base_url_site() . "uploads/raw_thumb_user/" . $row->new_avatar . '" width="150" />';
                    $data->avatar .= ' <a href="' . site_url($this->module_name . '/user/acceptAvatar/' . $row->id) . '" class="btn btn-icon btn-xs btn-success waves-effect waves-light" rel="tooltip" data-toggle="tooltip" data-placement="top" data-original-title="Accept"><i class="icon glyphicon glyphicon-ok" aria-hidden="true"></i></a>';
                    $data->avatar .= ' <a href="' . site_url($this->module_name . '/user/rejectAvatar/' . $row->id) . '" class="btn btn-icon btn-xs btn-danger waves-effect waves-light" rel="tooltip" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reject"><i class="icon glyphicon glyphicon-remove" aria-hidden="true"></i></a>';
                } else {
                    $data->avatar = '<img src="' . base_url_site() . "uploads/raw_thumb_user/" . $row->avatar . '" width="150" />';
                }
                /*$data->age = (int)date('Y') - $row->year . ' år';*/
                $data->age = $this->printAge($row->birthday, $row->year);
                $data->region = $row->region;
                if ($row->type == 2) {
                    $data->membership = "Gold";
                } else {
                    $data->membership = "Silver";
                }
                $data->dt_create = $row->dt_create;
                if($row->deactivation == 0){
                    $data->active = ' <a class="btn btn-icon btn-xs btn-success waves-effect waves-light" rel="tooltip" data-toggle="tooltip" data-placement="top"><i class="icon glyphicon glyphicon-ok" aria-hidden="true"></i></a>';
                } else {
                    $data->active = ' <a class="btn btn-icon btn-xs btn-danger waves-effect waves-light" rel="tooltip" data-toggle="tooltip" data-placement="top"><i class="icon glyphicon glyphicon-remove" aria-hidden="true"></i></a>';
                }

                if($row->deleted != null){
                    $data->deleted = ' <a class="btn btn-icon btn-xs btn-success waves-effect waves-light" rel="tooltip" data-toggle="tooltip" data-placement="top"><i class="icon glyphicon glyphicon-ok" aria-hidden="true"></i></a>';
                } else {
                    $data->deleted = ' <a class="btn btn-icon btn-xs btn-danger waves-effect waves-light" rel="tooltip" data-toggle="tooltip" data-placement="top"><i class="icon glyphicon glyphicon-remove" aria-hidden="true"></i></a>';
                }
                //ACTION
                $data->action = "";
                $data->action .= ($this->check->check('edit')) ? icon_edit($this->module_name . '/user/edit/' . $row->id . '/' . $offset) : "";
                $data->action .= '<span id="publish' . $row->id . '">';
                $data->action .= ($this->check->check('edit')) ? icon_active("'user'", "'id'", $row->id, $row->bl_active) : "";
                $data->action .= '</span>';
                if ($this->check->check('del')) {
                    $data->action .= '<input type="hidden" id="linkDelete-' . $row->id . '" name="linkDelete-' . $row->id . '" value="' . site_url($this->module_name . "/user/del/") . '"/>';
                    $data->action .= icon_delete($row->id);
                }
                $rows[] = $data;
            }
        } else {
            $rows = array();
        }
        $return['rows'] = $rows;
        $return['total'] = $total;
        header('Content-Type: application/json');
        echo json_encode($return);
        return;
    }

    function add()
    {
        $this->check->check('add', '', '', base_url());
        $this->form_validation->set_rules('name', "Name", 'trim|required');
        $this->form_validation->set_rules('email', "Email", 'trim|required|valid_email');
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passwordconfirm]');
            $this->form_validation->set_rules('passwordconfirm', 'Password confirmation', 'trim|required');
        }
        $this->form_validation->set_rules('birthday', "Birthday", 'trim|required');
        $this->form_validation->set_rules('gender', "Gender", 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->message = validation_errors();
        } else {
            $config['upload_path'] = $this->config->item('root') . "uploads/user/";
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = $this->config->item('maxupload');
            $config['encrypt_name'] = TRUE;  //rename to random string image
            $this->load->library('upload', $config);
            if (isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != "") {
                if ($this->upload->do_upload('avatar')) {
                    $data_img = $this->upload->data();
                } else {
                    $this->session->set_flashdata('message', "Upload image failed");
                    redirect(site_url($this->module_name . '/user/add'));
                }
            } else {
                $data_img['file_name'] = NULL;
            }
            $DB['avatar'] = $data_img['file_name'];
            $DB['name'] = $this->input->post('name');
            $DB['email'] = $this->input->post('email');
            if ($this->input->post('password')) {
                $DB['password'] = md5($this->input->post('password'));
            }
            $birthday = explode("/", $this->input->post('birthday'));
            $DB['day'] = $birthday[0];
            $DB['month'] = $birthday[1];
            $DB['year'] = $birthday[2];
            $DB['birthday'] = $this->input->post('birthday');
            $DB['gender'] = $this->input->post('gender');
            $DB['type'] = $this->input->post('type');
            $DB['description'] = $this->input->post('description');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $id = $this->user->save_data($DB);
            if ($id) {
                $this->session->set_flashdata('message', lang('admin.save_successful'));
                redirect(site_url($this->module_name . '/user/index'));
            } else {
                $this->message = lang('admin.save_unsuccessful');
            }
        }
        $data['title'] = lang('admin.add');
        $data['message'] = $this->message;
        $data['page'] = 'user/add';
        $this->load->view('templates', $data);
    }

    function edit($id, $page = 0)
    {
        $this->check->check('add', '', '', base_url());
        $this->form_validation->set_rules('name', "Name", 'trim|required');
        $this->form_validation->set_rules('email', "Email", 'trim|required|valid_email');
        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passwordconfirm]');
            $this->form_validation->set_rules('passwordconfirm', 'Password confirmation', 'trim|required');
        }
        $this->form_validation->set_rules('gender', "Gender", 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->message = validation_errors();
        } else {
            $config['upload_path'] = $this->config->item('root') . "uploads/user/";
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = $this->config->item('maxupload');
            $config['encrypt_name'] = TRUE;  //rename to random string image
            $this->load->library('upload', $config);
            if (isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != "") {
                if ($this->upload->do_upload('avatar')) {
                    $data_img = $this->upload->data();
                    $DB['avatar'] = $data_img['file_name'];
                } else {
                    $this->session->set_flashdata('message', "Upload image failed");
                    redirect(site_url($this->module_name . '/user/edit/' . $id . '/' . $page));
                }
            }
            $DB['name'] = $this->input->post('name');
            $DB['email'] = $this->input->post('email');
            if ($this->input->post('password')) {
                $DB['password'] = md5($this->input->post('password'));
            }
            if (!empty($this->input->post('birthday'))) {
                $birthday = explode("/", $this->input->post('birthday'));
                $DB['day'] = $birthday[0];
                $DB['month'] = $birthday[1];
                $DB['year'] = $birthday[2];
                $DB['birthday'] = $this->input->post('birthday');
            }
            $DB['gender'] = $this->input->post('gender');
            $DB['type'] = $this->input->post('type');
            $expired_at = explode('/', $this->input->post('expired_at'));
            $DB['expired_at'] = mktime('0', '0', '0', $expired_at[1], $expired_at[0], $expired_at[2]);
            $DB['description'] = $this->input->post('description');
            $DB['dt_update'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = $this->input->post('bl_active');;
            $id = $this->user->save_data($DB, $id);
            if ($id) {
                $this->session->set_flashdata('message', lang('admin.save_successful'));
                redirect(site_url($this->module_name . '/user/index/' . $page));
            } else {
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
        $check = $this->check->check('del', '', '');
        if ($check) {
            $id = $this->input->post('id', true);
            $user = $this->user->getUserInfo($id);
            if ($this->user->delete_data($id)) {
                //Delete user in firebase
                $this->_deleteUserInFirebase($id);
                //Delete user in mailjet
                $this->_deleteUserInMailjet($user->email);
                //End
                $data['status'] = true;
                $data['message'] = lang('admin.delete_successful');
            } else {
                $data['status'] = false;
                $data['message'] = lang('admin.delete_unsuccessful');
            }
        } else {
            $data['status'] = false;
            $data['message'] = lang('admin.delete_unsuccessful');
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function dels()
    {
        $this->check->check('dels', '', '');
        $itemid = $this->input->post('id', true);
        if ($itemid) {
            for ($i = 0; $i < sizeof($itemid); $i++) {
                if ($itemid[$i]) {
                    if ($this->user->delete_data($itemid[$i])) {
                        //Delete user in firebase
                        $this->_deleteUserInFirebase($itemid[$i]);
                        //End
                        $data['status'] = true;
                        $data['message'] = lang('admin.delete_successful');
                    } else {
                        $data['status'] = false;
                        $data['message'] = lang('admin.delete_unsuccessful');
                    }
                }
            }
        } else {
            $data['status'] = false;
            $data['message'] = lang('admin.delete_unsuccessful');
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function export()
    {
        $this->check->check('export', '', '', base_url());
        $data['title'] = 'Xuất thông tin thành viên';
        $this->form_validation->set_rules('tungay', 'Ngày bắt đầu', 'required');
        $this->form_validation->set_rules('denngay', 'Ngày kết thúc', 'required');
        if ($this->form_validation->run() == false) {
            $this->pre_message = validation_errors();
        } else {
            $from = $this->input->post('tungay') . " 00:00:00";
            $to = $this->input->post('denngay') . " 23:59:59";
            $list = $this->member->export_user($from, $to);
            ini_set('memory_limit', '10000M');
            memory_get_peak_usage(true);
            require $this->config->item('phpexcel') . 'PHPExcel.php';
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
            $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'Danh sách thành viên từ: ' . date("d/m/Y", strtotime($this->input->post('tungay'))) . ' đến ngày ' . date("d/m/Y", strtotime($this->input->post('denngay'))));
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
            $i = 4;
            foreach ($list as $key => $rs):
                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('A' . $i, $key + 1);

                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('B' . $i, $rs->name);

                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('C' . $i, $rs->avatar);

                $this->phpexcel->setActiveSheetIndex(0)->setCellValue('D' . $i, $rs->password);
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

            $date = date('H_i_s_d_m_Y', time());
            // Redirect output to a client's web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            #header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="thanh_vien_' . $date . '.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 2020 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
            #$objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'member/export';
        $this->site_library->load($this->_templates['page'], $data);
    }

    public function acceptAvatar($userId)
    {
        $avatar = $this->user->getAvatar($userId);

        $noAvatarArr = array('no-avatar1.png', 'no-avatar2.png');
        $defaultAvatars = array_merge($noAvatarArr, $this->config->item('male_avatar'), $this->config->item('female_avatar'));

        if(!in_array($avatar->pre_avatar, $defaultAvatars)){
            @unlink($this->config->item('root') . "uploads" . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . $avatar->pre_avatar);
            @unlink($this->config->item('root') . "uploads" . DIRECTORY_SEPARATOR . "thumb_user" . DIRECTORY_SEPARATOR . $avatar->pre_avatar);
            @unlink($this->config->item('root') . "uploads" . DIRECTORY_SEPARATOR . "raw_thumb_user" . DIRECTORY_SEPARATOR . $avatar->pre_avatar);
        }

        $this->user->updateCurrentAvatar($userId);

        $user = $this->user->getUserInfo($userId);
        $content = 'Hej ' . $user->name . '<br /><br />
                        Din avatar er godkendt.<br /><br />
                        <a href="' . base_url() . '">Habibidating.dk®</a>';
        $this->sendEmail([$user->email], 'Habibidating.dk - Din avatar er godkendt', $content);

        //Update avatar for cometchat
        /*$newAvatar = $this->user->getCurrentAvatar($userId);
        $params = json_encode(array(
            'avatar' => $this->config->item('site').'/uploads/thumb_user/'.$newAvatar
        ));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api-eu.cometchat.io/v2.0/users/'.$userId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Apikey: '.$this->config->item('comet_full_api_key');
        $headers[] = 'Appid: '.$this->config->item('comet_app_id');
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);*/
        ///

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function rejectAvatar($userId)
    {
        $newAvatar = $this->user->getNewAvatar($userId);

        @unlink($this->config->item('root') . "uploads" . DIRECTORY_SEPARATOR . "user" . DIRECTORY_SEPARATOR . $newAvatar);
        @unlink($this->config->item('root') . "uploads" . DIRECTORY_SEPARATOR . "thumb_user" . DIRECTORY_SEPARATOR . $newAvatar);
        @unlink($this->config->item('root') . "uploads" . DIRECTORY_SEPARATOR . "raw_thumb_user" . DIRECTORY_SEPARATOR . $newAvatar);

        $this->user->deleteNewAvatar($userId);

        $user = $this->user->getUserInfo($userId);
        $content = 'Hej ' . $user->name . '<br /><br />
                        Din avatar er ikke godkendt.<br /><br />
                        <a href="' . base_url() . '">Habibidating.dk®</a>';
        $this->sendEmail([$user->email], 'Habibidating.dk - Din avatar er ikke godkendt', $content);

        redirect($_SERVER['HTTP_REFERER']);
    }

    function sendEmail($emails, $subject, $content, $data = array(), $from = null, $mailType = 'html')
    {
        $configEmail['mailtype'] = $mailType;
        $configEmail['protocol'] = 'smtp';
        $configEmail['smtp_host'] = 'smtp.unoeuro.com';
        $configEmail['smtp_user'] = $this->config->item('sender_email');
        $configEmail['smtp_pass'] = $this->config->item('email_password');
        $configEmail['smtp_port'] = 587;
        $configEmail['smtp_crypto'] = 'tls';
        $configEmail['smtp_timeout'] = 30;

        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->initialize($configEmail);
        try {
            foreach ($emails as $email) {
                $this->email->clear();
                $this->email->to($email);
                if ($from == NULL) {
                    $this->email->from($this->config->item('sender_email'), 'Habibidating.dk');
                } else {
                    $this->email->from($from, 'Habibidating.dk');
                }
                $this->email->subject($subject);
                $this->email->message($content);
                $this->email->send();
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    function printAge($birthday, $year)
    {
        if (!empty($birthday)) {
            $birthDate = explode("/", $birthday);
        } else {
            $birthday = '1/1/' . $year;
            $birthDate = explode("/", $birthday);
        }
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        return $age . ' år';
    }

    private function _deleteUserInFirebase($userId){
        $this->load->library('firebase');
        $firebase = $this->firebase->init();
        $db = $firebase->getDatabase();
        $auth = $firebase->getAuth();

        $auth->deleteUser($userId);
        $db->getReference('users/'.$userId)->remove();
    }

    private function _deleteUserInMailjet($email){
        $pubKey = $this->config->item('mailJetPublicKey');
        $secKey = $this->config->item('mailJetSecretKey');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3/REST/contact/'.urlencode($email));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, $pubKey.':'.$secKey);

        $result = curl_exec($ch);
        $contactId = json_decode($result)->Data[0]->ID;

        //Delete contact
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v4/contacts/'.$contactId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        curl_setopt($ch, CURLOPT_USERPWD, $pubKey.':'.$secKey);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
}

?>