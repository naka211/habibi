<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invitationer extends MX_Controller {
	function __construct(){
        parent::__construct();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('invita_model','invita');
        $this->load->model('user_model', 'user');
        $this->load->library('user_agent');
        $this->language = $this->lang->lang();

        //Get meta data from url
        $this->_meta = $this->general_model->getMetaDataFromUrl();
    }

    protected function middleware(){
        return array('Checklogin|only:index,invitervip,opretetevent,offentliginvitation,offentligevent,slet', 'Checkgold|only:invitervip,opretetevent,offentliginvitation,offentligevent');
    }

    function index(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        //Clear session when created invitation
        /*if($this->session->userdata['invita']){
            $this->session->unset_userdata('invita');
        }
        if($this->session->userdata['listUser']){
            $this->session->unset_userdata('listUser');
        }*/
        $SearchUser = array('year_from' => '', 'year_to' => '', 'height_from' => '', 'height_to' => ''
                            , 'gender' => '', 'relationship' => '', 'children' => '', 'ethnic_origin' => ''
                            , 'religion' => '', 'training' => '', 'body' => '');
        $this->session->unset_userdata($SearchUser);
        $data['user'] = $this->session->userdata['user'];
		$data['page'] = 'invitationer/index';
		$this->load->view('templates', $data);
	}
    
    function invitervip(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata['user'];
        //$this->form_validation->set_rules('userID[]','Opret en VIP invitation op til 5 personer','trim|required');
        $this->form_validation->set_rules('order_item','Vælg venligst en værdibevis','trim|required');
		if($this->form_validation->run()== FALSE){
			$data['message'] = validation_errors();
		}else{
            if($this->input->post()){
                $userID1 = $this->input->post('userID');
                $userID2 = $this->session->userdata('listUser');
                if(empty($userID1)){
                    $userID1 = array();
                }
                if(empty($userID2)){
                    $userID2 = array();
                }
                $userID = array_unique (array_merge ($userID1, $userID2));
                $DB['times'] = $this->input->post('time');
                $DB['userID'] = $data['user']->id;
                $DB['name'] = 'VIP INVITATION';
                $DB['type'] = 1;
                $DB['order_item'] = $this->input->post('order_item');
                $DB['dt_create'] = date('Y-m-d H:i:s');
                $DB['bl_active'] = 1;
                $mobile = $this->agent->mobile();
                if($mobile){
                    $DB['device'] = 'Mobile';
                }else{
                    $DB['device'] = 'Desktop';
                }
                $DB['times_end'] = time()+$DB['times']*60*60*count($userID);
                $id = $this->invita->saveDating($DB);
                //Save User
                $timeNext = $DB['times']*60*60;
                $timeStart = time();
                if($id){
                    if($userID){
                        for($i=0;$i<count($userID);$i++){
                            $DBu['time_start'] = $timeStart;
                            $DBu['time_end'] = $DBu['time_start']+$timeNext;
                            if($DBu['time_start'] < strtotime('7am')){
                                $DBu['time_start'] = strtotime('7am');
                                $DBu['time_end'] = $DBu['time_start']+$timeNext;
                            }
                            if($DBu['time_end'] > strtotime('11pm')){
                                $DBu['time_start'] = strtotime('tomorrow 7am');
                                $DBu['time_end'] = $DBu['time_start']+$timeNext;
                            }
                            $DBu['datingID'] = $id;
                            $DBu['user'] = $userID[$i];
                            $DBu['dt_create'] = date('Y-m-d H:i:s');
                            $DBu['bl_active'] = 1;
                            $this->invita->saveDatingUser($DBu);
                            $timeStart = $DBu['time_end'];
                            $this->user->addStatus($data['user']->id, $userID[$i], 'Invite');
                        }
                    }
                    //Update order item
                    $DBo['used'] = 1;
                    $this->invita->saveOrderItem($DBo,$DB['order_item']);

                    //Update end time of dating
                    $updateDB['times_end'] = $timeStart;
                    $this->invita->saveDating($updateDB, $id);
                }
                //Go to Mine invitationer
                redirect(site_url('user/myinvitationer'));
            }
        }
        
        $data['orderitem'] = $this->invita->getOrderItem($data['user']->id);
        $list = $this->session->userdata('listUser');
        if($list){
            $data['numUser'] = count($list);
        }else{
            $data['numUser'] = "";
        }
		$data['page'] = 'invitationer/invitervip';
		$this->load->view('templates', $data);
    }
    
    function opretetevent(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata['user'];
        /** Upload images*/
        if(isset($_FILES['image']['name'])&&$_FILES['image']['name'][0]!=""){
            $config['upload_path'] = $this->config->item('root')."uploads/invita/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
            if(isset($_FILES['image']['name'])){
                $data_img = $this->upload->do_multi_upload('image');
    			if ($data_img){	
    				$data_img = $data_img;
    			}else {
    				$data_img[] = NULL;
    			}
    		}else {
    			$data_img[] = NULL;
            }
            $images_arr = array();
        	foreach($_FILES['image']['name'] as $key=>$val){
        		$image_name = $_FILES['image']['name'][$key];
        		$tmp_name 	= $_FILES['image']['tmp_name'][$key];
        		$size 		= $_FILES['image']['size'][$key];
        		$type 		= $_FILES['image']['type'][$key];
        		$error 		= $_FILES['image']['error'][$key];
        		//display images without stored
        		$extra_info = getimagesize($_FILES['image']['tmp_name'][$key]);
            	$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['image']['tmp_name'][$key]));
        	}
            if($images_arr){
                $i=0;$k=1;
        		foreach($images_arr as $image_src){if($k<=5){ ?>
        			<li id="show_images_<?php echo $i;?>">
                        <a class="close_img" href="javascript:void(0)" onclick="deleteImages('show_images_<?php echo $i;?>');"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i></a>
                        <div style="width: 95px !important; height: 95px !important; overflow: hidden;">
                            <img src="<?php echo $image_src;?>" width="95" height="95" alt="" class="img-responsive"/>
                        </div>
                        <input type="hidden" name="data_img[]" value="<?php echo $data_img[$i]['file_name'];?>" />
                    </li>
        	<?php }$i++;$k++; }}
            return;
        }
        
        $this->form_validation->set_rules('userID[]','Opret en VIP invitation op til 5 personer','trim|required');
        $this->form_validation->set_rules('title','Titel','trim|required');
        $this->form_validation->set_rules('content','Beskrivelse','trim|required');
		if($this->form_validation->run()== FALSE){
			$data['message'] = validation_errors();
		}else{
            if($this->input->post()){
                $userID = $this->input->post('userID');
                $images = $this->input->post('data_img');
                $DB['times'] = $this->input->post('time');
                $DB['userID'] = $data['user']->id;
                $DB['name'] = 'BEGIVENHED';
                $DB['type'] = 3;
                $DB['title'] = $this->input->post('title');
                $DB['content'] = $this->input->post('content');
                $DB['payment'] = 1;
                $DB['dt_create'] = date('Y-m-d H:i:s');
                $DB['bl_active'] = 1;
                $mobile = $this->agent->mobile();
                if($mobile){
                    $DB['device'] = 'Mobile';
                }else{
                    $DB['device'] = 'Desktop';
                }
                $DB['times_end'] = time()+($DB['times']*60*60*count($userID));
                $id = $this->invita->saveDating($DB);
                $this->session->set_userdata('datingID',$id);
                //Save User
                $timeNext = $DB['times']*60*60;
                $timeStart = time();
                if($id){
                    //Save uer
                    if($userID){
                        for($i=0;$i<count($userID);$i++){
                            $DBu['time_start'] = $timeStart;
                            $DBu['time_end'] = $DBu['time_start']+$timeNext;
                            $DBu['datingID'] = $id;
                            $DBu['user'] = $userID[$i];
                            $DBu['dt_create'] = date('Y-m-d H:i:s');
                            $DBu['bl_active'] = 1;
                            $this->invita->saveDatingUser($DBu);
                            $timeStart = $DBu['time_end'];
                            $this->user->addStatus($data['user']->id, $userID[$i], 'Invite');
                        }
                    }
                    //Save image
                    if($images){
                        for($i=0;$i<count($images);$i++){
                            $DBi['datingID'] = $id;
                            $DBi['image'] = $images[$i];
                            $DBi['dt_create'] = date('Y-m-d H:i:s');
                            $DBi['bl_active'] = 1;
                            $this->invita->saveDatingImage($DBi);
                        }
                    } 
                }
                //Go to payment
                //redirect(site_url('payment/invitationer'));
                //Go to Mine invitationer
                redirect(site_url('user/myinvitationer'));
            }
        }
		$data['page'] = 'invitationer/opretetevent';
		$this->load->view('templates', $data);
    }
    
    function offentliginvitation(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        $data['user'] = $this->session->userdata['user'];
        $this->form_validation->set_rules('order_item','Vælg venligst en værdibevis','trim|required');
		if($this->form_validation->run()== FALSE){
			$data['message'] = validation_errors();
		}else{
            if($this->input->post()){
                $userID = $this->session->userdata('listUser');
                $userID = json_decode($userID);
                $DB['times'] = $this->input->post('time');
                $DB['times_end'] = time() + ($DB['times']*60*60);
                $DB['userID'] = $data['user']->id;
                $DB['name'] = 'OFFENTLIG INVITATION';
                $DB['type'] = 2;
                $DB['order_item'] = $this->input->post('order_item');
                $DB['dt_create'] = date('Y-m-d H:i:s');
                $DB['bl_active'] = 1;
                $mobile = $this->agent->mobile();
                if($mobile){
                    $DB['device'] = 'Mobile';
                }else{
                    $DB['device'] = 'Desktop';
                }
                $id = $this->invita->saveDating($DB);
                //Save User
                $timeStart = time();
                $timeEnd = $timeStart+(int)$DB['times']*60*60;
                if($id){
                    if($userID){
                        for($i=0;$i<count($userID);$i++){
                            $DBu['time_start'] = $timeStart;
                            $DBu['time_end'] = $timeEnd;
                            $DBu['datingID'] = $id;
                            $DBu['user'] = $userID[$i];
                            $DBu['dt_create'] = date('Y-m-d H:i:s');
                            $DBu['bl_active'] = 1;
                            $this->invita->saveDatingUser($DBu);
                            $this->user->addStatus($data['user']->id, $userID[$i], 'Invite');
                        }
                    }
                    //Update order item
                    $DBo['used'] = 1;
                    $this->invita->saveOrderItem($DBo,$DB['order_item']);
                }
                //Go to Mine invitationer
                $this->session->unset_userdata('invita');
                $this->session->unset_userdata('listUser');
                redirect(site_url('user/myinvitationer'));
            }
        }
        $data['orderitem'] = $this->invita->getOrderItem($data['user']->id);
        $list = $this->session->userdata('listUser');
        $list = json_decode($list);
        if($list){
            $data['numUser'] = count($list);
        }else{
            $data['numUser'] = "";
        }
		$data['page'] = 'invitationer/offentliginvitation';
		$this->load->view('templates', $data);
    }
    
    function offentligevent(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata['user'];
        if(isset($_FILES['image']['name'])&&$_FILES['image']['name'][0]!=""){
            $config['upload_path'] = $this->config->item('root')."uploads/invita/";
    		$config['allowed_types'] = 'gif|jpg|jpeg|png';
    		$config['max_size']	= $this->config->item('maxupload');
    		$config['encrypt_name']	= TRUE;  //rename to random string image
            $this->load->library('upload', $config);
            if(isset($_FILES['image']['name'])){
                $data_img = $this->upload->do_multi_upload('image');
    			if ($data_img){	
    				$data_img = $data_img;
    			}else {
    				$data_img[] = NULL;
    			}
    		}else {
    			$data_img[] = NULL;
            }
            $images_arr = array();
        	foreach($_FILES['image']['name'] as $key=>$val){
        		$image_name = $_FILES['image']['name'][$key];
        		$tmp_name 	= $_FILES['image']['tmp_name'][$key];
        		$size 		= $_FILES['image']['size'][$key];
        		$type 		= $_FILES['image']['type'][$key];
        		$error 		= $_FILES['image']['error'][$key];
        		//display images without stored
        		$extra_info = getimagesize($_FILES['image']['tmp_name'][$key]);
            	$images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['image']['tmp_name'][$key]));
        	}
            if($images_arr){
                $i=0;$k=1;
        		foreach($images_arr as $image_src){if($k<=5){ ?>
        			<li id="show_images_<?php echo $i;?>">
                        <a class="close_img" href="javascript:void(0)" onclick="deleteImages('show_images_<?php echo $i;?>');"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i></a>
                        <div style="width: 95px !important; height: 95px !important; overflow: hidden;">
                            <img src="<?php echo $image_src;?>" width="95" height="95" alt="" class="img-responsive"/>
                        </div>
                        <input type="hidden" name="data_img[]" value="<?php echo $data_img[$i]['file_name'];?>" />
                    </li>
        	<?php }$i++;$k++; }}
            return;
        }
        
        //$this->form_validation->set_rules('userID[]','Opret en VIP invitation op til 5 personer','trim|required');
        $this->form_validation->set_rules('title','Titel','trim|required');
        $this->form_validation->set_rules('content','Beskrivelse','trim|required');
		if($this->form_validation->run()== FALSE){
			$data['message'] = validation_errors();
		}else{
            if($this->input->post()){
                $userID = $this->session->userdata('listUser');
                $userID = json_decode($userID);
                $images = $this->input->post('data_img');
                $DB['times'] = $this->input->post('time');
                $DB['times_end'] = time() + ($DB['times']*60*60);
                $DB['userID'] = $data['user']->id;
                $DB['name'] = 'OFFENTLIG HENDELSE';
                $DB['type'] = 4;
                $DB['title'] = $this->input->post('title');
                $DB['content'] = $this->input->post('content');
                $DB['payment'] = 1;
                $DB['dt_create'] = date('Y-m-d H:i:s');
                $DB['bl_active'] = 1;
                $mobile = $this->agent->mobile();
                if($mobile){
                    $DB['device'] = 'Mobile';
                }else{
                    $DB['device'] = 'Desktop';
                }
                $id = $this->invita->saveDating($DB);
                $this->session->set_userdata('datingID',$id);
                //Save User
                $timeStart = time();
                $timeEnd = $timeStart+(int)$DB['times']*60*60;
                if($id){
                    //Save uer
                    if($userID){
                        for($i=0;$i<count($userID);$i++){
                            $DBu['time_start'] = $timeStart;
                            $DBu['time_end'] = $timeEnd;
                            $DBu['datingID'] = $id;
                            $DBu['user'] = $userID[$i];
                            $DBu['dt_create'] = date('Y-m-d H:i:s');
                            $DBu['bl_active'] = 1;
                            $this->invita->saveDatingUser($DBu);
                            $this->user->addStatus($data['user']->id, $userID[$i], 'Invite');
                        }
                    }
                    //Save image
                    if($images){
                        for($i=0;$i<count($images);$i++){
                            $DBi['datingID'] = $id;
                            $DBi['image'] = $images[$i];
                            $DBi['dt_create'] = date('Y-m-d H:i:s');
                            $DBi['bl_active'] = 1;
                            $this->invita->saveDatingImage($DBi);
                        }
                    } 
                }
                //Go to payment
                $this->session->unset_userdata('invita');
                $this->session->unset_userdata('listUser');
                //redirect(site_url('payment/invitationer'));
                //Go to Mine invitationer
                redirect(site_url('user/myinvitationer'));
            }
        }
        $list = $this->session->userdata('listUser');
		$list = json_decode($list);
        if($list){
            $data['numUser'] = count($list);
        }else{
            $data['numUser'] = "";
        }
		$data['page'] = 'invitationer/offentligevent';
		$this->load->view('templates', $data);
    }
    function chooseUserSearch(){
        $listUser = $this->input->post('listUser');
        $listUser = json_encode($listUser);
        $this->session->set_userdata('listUser',$listUser);
        return true;
    }
    
    /** PAYMENT INVITATION*/
    function success(){
        $datingID = $this->session->userdata('datingID');
        if($datingID){
            //Update payment
            $DB['bl_active'] = 1;
            $DB['paymenttime'] = time();
            $this->invita->saveDating($DB,$datingID);
        }
        $this->session->unset_userdata('datingID');
        $this->session->unset_userdata('invita');
        redirect(site_url('user/myinvitationer'));
    }
    function cancel(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        
        $this->session->unset_userdata('datingID');
        $this->session->unset_userdata('invita');
        
		$data['page'] = 'invitationer/cancel';
		$this->load->view('templates', $data);
    }
    function callback(){
        //Check callback and save
        
        
    }
    /** END PAYMENT*/
    function slet(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata['user'];
        $data['tilbud'] = $this->invita->getMyTilbud($data['user']->id);
		$data['page'] = 'invitationer/slet';
		$this->load->view('templates', $data);
    }
    function sletTilbud(){
        $id = $this->input->post('id');
        //Get OrderID
        $order = $this->invita->getOrderFromItemID($id);
        if($order){
            $orderID = $order->orderID;
            //Send mail to admin
            $DB['orderID'] = $orderID;
            $admin = $this->config->item('email');
            $emailTo = array($admin);
            sendEmail($emailTo,'deleteTilbud',$DB,'');
            //Delete from DB
            $this->invita->deleteOrderItem($id);
            $data['status'] = true;
        }else{
            $orderID = NULL;
            $data['status'] = false;
        }
        header('Content-Type: application/json');
		echo json_encode($data);
        return;
    }
    
    /** Funciton ajax*/
    function listuser(){
        $user = $this->session->userdata('user');
        if($user){
            $ignore[] = $user->id;
        }else{
            $ignore = "";
        }
        $type = $this->input->post('type');
        if($type == 1){
            $data['title'] = 'Vælg fra favoritlisten';
            $listUsers = $this->user->getFavorite(20,0,$user->id);
            if($listUsers){
                $i=0;
                foreach($listUsers as $row){
                    $users[$i]['id'] = $row->id;
                    $users[$i]['name'] = $row->name;
                    $users[$i]['birthday'] = $row->birthday;
                    $users[$i]['code'] = $row->code;
                    $users[$i]['facebook'] = $row->facebook;
                    $users[$i]['avatar'] = $row->avatar;
                    /*if($row->facebook && $row->avatar){
                        $users[$i]['avatar'] = $row->avatar;
                    }else{
                        $photo = $this->user->getPhoto($row->id);
                        if($photo){
                            $users[$i]['avatar'] = $photo[0]->image;
                        }else{
                            $users[$i]['avatar'] = "";
                        }
                    }*/
                    $i++;
                }
            }else{
                $users = "";
            }
            $data['list'] = $users;
        }else{
            $data['title'] = 'Invitér en VIP bruger';
            $listUsers = $this->user->getList(20,0,NULL,$ignore);
            if($listUsers){
                $i=0;
                foreach($listUsers as $row){
                    $users[$i]['id'] = $row->id;
                    $users[$i]['name'] = $row->name;
                    $users[$i]['birthday'] = $row->birthday;
                    $users[$i]['code'] = $row->code;
                    $users[$i]['facebook'] = $row->facebook;
                    $users[$i]['avatar'] = $row->avatar;
                    /*if($row->facebook && $row->avatar){
                        $users[$i]['avatar'] = $row->avatar;
                    }else{
                        $photo = $this->user->getPhoto($row->id);
                        if($photo){
                            $users[$i]['avatar'] = $photo[0]->image;
                        }else{
                            $users[$i]['avatar'] = "";
                        }
                    }*/
                    $i++;
                }
            }else{
                $users = "";
            }
            $data['list'] = $users;
        }
        $data['type'] = $type;
        $this->load->view('ajax/listuser', $data);
    }
    function finduser(){
        $search['name'] = $this->input->post('name');
        $type = $this->input->post('type');
        $user = $this->session->userdata('user');
        if($user){
            $ignore[] = $user->id;
        }else{
            $ignore = "";
        }
        if($type == 1){
            $listUsers = $this->user->getFavorite(20,0,$user->id,$search);
            if($listUsers){
                $i=0;
                foreach($listUsers as $row){
                    $users[$i]['id'] = $row->id;
                    $users[$i]['name'] = $row->name;
                    $users[$i]['birthday'] = $row->birthday;
                    $users[$i]['code'] = $row->code;
                    $users[$i]['facebook'] = $row->facebook;
                    if($row->facebook && $row->avatar){
                        $users[$i]['avatar'] = $row->avatar;
                    }else{
                        $photo = $this->user->getPhoto($row->id);
                        if($photo){
                            $users[$i]['avatar'] = $photo[0]->image;
                        }else{
                            $users[$i]['avatar'] = "";
                        }
                    }
                    $i++;
                }
            }else{
                $users = "";
            }
            $data['list'] = $users;
        }else{
            $listUsers = $this->user->getList(20,0,$search,$ignore);
            if($listUsers){
                $i=0;
                foreach($listUsers as $row){
                    $users[$i]['id'] = $row->id;
                    $users[$i]['name'] = $row->name;
                    $users[$i]['birthday'] = $row->birthday;
                    $users[$i]['code'] = $row->code;
                    $users[$i]['facebook'] = $row->facebook;
                    if($row->facebook && $row->avatar){
                        $users[$i]['avatar'] = $row->avatar;
                    }else{
                        $photo = $this->user->getPhoto($row->id);
                        if($photo){
                            $users[$i]['avatar'] = $photo[0]->image;
                        }else{
                            $users[$i]['avatar'] = "";
                        }
                    }
                    $i++;
                }
            }else{
                $users = "";
            }
            $data['list'] = $users;
        }
        $this->load->view('ajax/finduser', $data);
    }
    function chooseUser(){
        $listUser = $this->input->post('listUser');
        if(count($listUser)>5){
            $n = 5;
        }else{
            $n = count($listUser);
        }
        $inUser = array();
        for($i=0;$i<$n;$i++){
            $inUser[] = $listUser[$i];
        }
        $data['list'] = $this->user->getList(NULL,NULL,NULL,NULL,$inUser);
        $this->load->view('ajax/userchoose', $data);
    }

    function session_destroy(){
        var_dump($this->session->sess_destroy());exit();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */