<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends MX_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->session->set_userdata('last_visited', time());
        $this->setExpireSessionTime();
	}
	function index(){
		//Nothing to do
	}
    function deleteimage(){
         $table = $this->input->post('table');
		 $field = $this->input->post('field');
		 $id = $this->input->post('id');
         $fielddelete = $this->input->post('fielddelete');
         $this->db->set($fielddelete,"");
		 $this->db->where($field,$id);
		 $this->db->update($table);
		 echo true;
         return;
	}
    function deletedata(){
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        if($table == 'user_image'){
            $this->db->select('image');
            $this->db->from('user_image');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $image = $query->row();
            unlink("uploads/photo/".$image->image);
        }
        $query = $this->db->where('id',$id)->delete($table);
        echo true;
        return;
	}




    function checkEmail(){
        $user = $this->session->userdata('user');
        $email = $this->input->post('email', true);
        $userId =!empty($user)?$user->id:null;

        $exist = $this->user->checkUser($userId, null, $email);
        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }

    function checkName(){
        $user = $this->session->userdata('user');
        $name = $this->input->post('name', true);
        $userId = !empty($user)?$user->id:null;

        $exist = $this->user->checkUser($userId, $name);
        if ($exist) {
            echo 'false';
        } else {
            echo 'true';
        }
        exit;
    }

    /**
     * Generating age html
     */
    function generateToAgeSelection(){
        $fromAge = $this->input->post('fromAge', true);
        $htmlSelection = '';
        for($i = $fromAge + 1; $i <= 90; $i++){
            $htmlSelection .= '<option value="'.$i.'">'.$i.'</option>';
        }
        echo $htmlSelection;
        exit();
    }

    /**
     * Setting cookie for cookie information
     */
    function setCookie(){
        setcookie('ha_cookie', 1, time() + (86400 * 30), "/");
        die('ok');
    }

    /**
     * Setting cookie for panik information
     */
    function setCookiePanik(){
        setcookie('ha_panik_cookie', 1, time() + (86400 * 30), "/");
        die('ok');
    }

    function logout(){
        /** Login*/
        $message = $this->input->post('message');
        if(!empty($message)){
            setcookie('ha_message', $message, time() + (86400 * 300), "/");
        }
        $user = $this->session->userdata('user');
        if($user){
            $Login = array('isLoginSite', 'user', 'email', 'password');
            $this->session->unset_userdata($Login);
            $this->user->updateLogin($user->id, 0);
        }

        die('ok');
    }

    function setExpireSessionTime(){
        $user = $this->session->userdata('user');
        if($user){
            $this->user->setExpireSessionTime($user->id);
        }
    }

    function changeChatStatus(){
        $user = $this->session->userdata('user');
        $status = $this->input->post('status', true);
        $result = $this->db->set('chat', $status)
            ->where("id", $user->id)
            ->update("tb_user");
        if($result == false){
            die('0');
        } else {
            $user = $this->user->getUser($user->id);
            $this->session->set_userdata('user', $user);
            die('1');
        }
    }

    function sendBlink(){
        $profile_id = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');

        if ($user && $profile_id) {
            $DB['from_user_id'] = $user->id;
            $DB['to_user_id'] = $profile_id;
            $DB['seen'] = 0;
            $DB['send_at'] = time();
            $id = $this->user->sendBlink($DB);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function addFavorite(){
        $profile_id = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');

        if ($user && $profile_id) {
            $DB['user_from'] = $user->id;
            $DB['user_to'] = $profile_id;
            $DB['created_at'] = time();
            $id = $this->user->addFavorite($DB);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function addFavoriteInPage(){
        $this->addFavorite();
    }

    function removeFavorite(){
        $profile_id = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');

        if ($user && $profile_id) {
            $this->user->removeFavorite($user->id, $profile_id);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function removeFavoriteInPage(){
        $this->removeFavorite();
    }

    function blurAvatar(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');

        if ($user && $profileId) {
            $this->user->setBlurAvatar($user->id, $profileId, 0);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }
    function removeBlurAvatar(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');

        if ($user && $profileId) {
            $this->user->setBlurAvatar($user->id, $profileId, 1);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function blockUser(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->addUserToBlockedList($user->id, $profileId);
        $data['status'] = true;
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function unblockUser(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->removeUserToBlockList($user->id, $profileId);
        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function requestAddFriend(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');

        if($this->user->checkExistRequest($user->id, $profileId)){
            $data['status'] = false;
        } else {
            if ($user && $profileId) {
                $DB['user_from'] = $user->id;
                $DB['user_to'] = $profileId;
                $DB['status'] = 0;
                $DB['dt_create'] = time();
                $id = $this->user->addRequestAddFriend($DB);
                if($id){
                    $data['status'] = true;
                } else {
                    $data['status'] = false;
                }
            } else {
                $data['status'] = false;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function requestAddFriendInProfile(){
        $this->requestAddFriend();
    }
    public function requestAddFriendInFavorite(){
        $this->requestAddFriend();
    }

    public function reAddFriend(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->reAddFriend($user->id, $profileId, 0);
        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function unFriend(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->cancelRequestAddFriend($user->id, $profileId);
        //Delete visiting
        $this->user->deleteVisited($user->id, $profileId);
        //Delete visit me
        $this->user->deleteVisitMe($user->id, $profileId);
        //Delete blink
        $this->user->deleteBlink($user->id, $profileId);
        //Delete message
        $this->user->deleteMessage($user->id, $profileId);
        //Remove favorite
        $this->user->removeFavorite($user->id, $profileId);

        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function unFriendInProfile(){
        $this->unFriend();
    }

    public function cancelAddFriend(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->cancelRequestAddFriend($user->id, $profileId);
        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function cancelAddFriendInProfile(){
        $this->cancelAddFriend();
    }

    public function cancelAddFriendInFavorite(){
        $this->cancelAddFriend();
    }

    public function acceptAddFriend(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->updateFriendRequest($user->id, $profileId, 1);
        $this->user->insertFriendList($user->id, $profileId);
        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function rejectAddFriend(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->updateFriendRequest($user->id, $profileId, 2);
        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function loadMoreMessages(){
        $user = $this->session->userdata('user');
        $profileId = $this->input->post('profileId', true);
        $total = $this->user->getNumMessages($user->id, $profileId);
        $num = $this->input->post('num', true);

        $messages = $this->user->getMessages($user->id, $profileId, 10, $num);
        $html = '';
        $messages = array_reverse($messages);
        $newNum = $num + 10;
        if($total > $newNum){
            $loadMoreFunction = 'onclick="loadMoreMessages('.$profileId.','.$newNum.', false)"';
            $html .= '<li style="text-align: center;" id="loadMoreMessage">
                            <a style="color: #f19906;" href="javascript:void(0)" '.$loadMoreFunction.'>Indlæs tidligere meddelelser</a>
                        </li>';
        }
        foreach ($messages as $message){

            if($message->uid == $profileId){
                $class = 'other';
            } else {
                $class = 'you';
            }
            $content = $this->renderMessage($message->message, $message->messageType, $num);
            $html .= '<li class="'.$class.'">
                            <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$message->avatar.'" /></a>'.$content.'
                            <div class="date">Sendt: d. '.date("d/m/Y", $message->dt_create).' kl. '.date("H:i", $message->dt_create).'</div>
                        </li>';
        }
        echo $html;
        exit();
    }

    public function renderMessage($message, $messageType, $num){
        switch ($messageType){
            case 'text':
                $html = '<div class="message message'.$num.'"><p>'.nl2br($message).'</p></div>';
                break;
            case 'image':
                $html = '<div class="message_media">
                        <p class="img_content">
                        <a href="'.$message.'" data-fancybox="images"><img src="'.$message.'" alt="" class="img-responsive"></a>
                        </p>
                    </div>';
                break;
            case 'audio':
                $html = '<div class="message_media">
                        <p class="img_content">
                        <audio controls>
                            <source src="'.$message.'" type="audio/mp3">
                        </audio>
                        </p>
                    </div>';
                break;
            case 'video':
                $html = '<div class="message_media">
                        <p class="img_content">
                        <video controls>
                            <source src="'.$message.'" type="video/mp4">
                        </video>
                        </p>
                    </div>';
                break;
        }
        return $html;
    }

    function sendMessage(){
        $user = $this->session->userdata('user');
        if ($user) {
            $DB['user_from'] = $user->id;
            $DB['user_to'] = $this->input->post('user_to');
            $DB['message'] = $this->input->post('message');
            $DB['seen'] = 0;
            $DB['dt_create'] = time();
            $messageId = $this->user->saveMessage($DB);
            $data['messageId'] = $messageId;

            $item = $this->user->getUser($user->id);
            $html = '<li class="you">
                            <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$item->avatar.'" /></a>
                            <div class="message message'.$messageId.'"><p>'.$DB['message'].'</p></div>
                            <div class="date">Sendt: d. '.date("d/m/Y", $DB['dt_create']).' kl. '.date("H:i", $DB['dt_create']).'</div>
                        </li>';
            $data['html'] = $html;
            echo json_encode($data);
            return;
        }
        echo "";
        return;
    }

    function checkMessage(){
        $user = $this->session->userdata('user');
        $profileId = $this->input->post('profileId');
        $emptyMessage = $this->user->checkEmptyMessage($user->id, $profileId);
        if($emptyMessage){
            $data['emptyMessage'] = true;
        } else {
            $data['emptyMessage'] = false;
        }

        $messages = $this->user->checkNewMessage($user->id, $profileId);
        if(!empty($messages)){
            $html = '';
            foreach($messages as $message){
                $profile = $this->user->getUser($message->user_from);
                $content = $this->renderMessage($message->message, $message->messageType);
                $html .= '<li class="other">
                            <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$profile->avatar.'" /></a>
                            '.$content.'
                            <div class="date">Sendt: d. '.date("d/m/Y", $message->dt_create).' kl. '.date("H:i", $message->dt_create).'</div>
                        </li>';
            }
            $data['newMessage'] = true;
            $data['html'] = $html;

            $this->user->setSeenMessage($user->id, $profileId);
        } else {
            $data['newMessage'] = false;
            $data['html'] = '';
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function loadCometMessages($userId, $profileId){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.cometchat.com/v1.8/users/'.$userId.'/users/'.$profileId.'/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


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
        print_r(json_decode($result));exit();
        curl_close($ch);
    }

    public function saveMessageToComet(){
        $userId = $this->session->userdata('user')->id;
        $profileId = $this->input->post('profileId');
        $message = $this->input->post('message');
        $messageId = $this->input->post('messageId');
        $messageType = 'text';

        $params = json_encode(array(
            'receiver' => (string)$profileId,
            'receiverType' => 'user',
            'category' => 'message',
            'type' => $messageType,
            'data' => json_encode(array('text' => $message))
        ));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.cometchat.com/v1.8/users/'.$userId.'/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

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

        //Update comet message id to db
        $returnData = json_decode($result);
        $DB['cometMessageId'] = $returnData->data->id;
        $this->user->updateCometMessageId($messageId, $DB);

        curl_close($ch);
    }

    public function sendImage(){
        $userId = $this->session->userdata('user')->id;

        //Save message
        $DB['cometMessageId'] = $this->input->post('cometMessageId');
        $DB['user_from'] = $userId;
        $DB['user_to'] = $this->input->post('profileId');
        $DB['message'] = $this->input->post('message');
        $DB['messageType'] = 'image';
        $DB['seen'] = 0;
        $DB['dt_create'] = time();
        $this->user->saveMessage($DB);

        //Generate message html
        $item = $this->user->getUser($userId);
        $html = '<li class="you">
                    <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$item->avatar.'" /></a>
                    <div class="message_media">
                        <p class="img_content">
                            <a href="'.$this->input->post('message').'" data-fancybox="images"><img src="'.$this->input->post('message').'" alt="" class="img-responsive"></a>
                        </p>
                    </div>
                    <div class="date">Sendt: d. '.date("d/m/Y", $DB['dt_create']).' kl. '.date("H:i", $DB['dt_create']).'</div>
                </li>';
        echo $html;
        return;
    }

    public function loadMultiFilter(){
        $user = $this->session->userdata('user');

        $type = $this->input->post('type');
        $label = $this->input->post('label');
        $selectedStr = $this->input->post('selectedStr');

        if($type == 'gender' && empty($selectedStr)){
            $selectedStr = (string)$user->find_gender;
        }

        $arr['gender'] = array(1=>'Mand', 2=>'Kvinde');
        $arr['relationship'] = array('Aldrig gift', 'Separeret', 'Skilt', 'Enke/enkemand', 'Det får du at vide senere');
        $arr['children'] = array('Nej', 'Ja; hjemmeboende', 'Ja; udeboende', '1', '2', '3', '3+');
        $arr['ethnic'] = array('Europæisk', 'Afrikansk', 'Latinamerikansk', 'Asiatisk', 'Indisk', 'Arabisk', 'Blandet/andet');
        $arr['religion'] = array('Suni', 'Shia', 'Andet');
        $arr['training'] = array('Ingen eksamen', 'Gymnasium/HF', 'Fagskole', 'Bachelorgrad', 'Kandidat/ph.d.');
        $arr['body'] = array('Slank', 'Atletisk', 'Gennemsnitlig', 'Buttet');
        $arr['smoking'] = array('Ja', 'Nej', 'Ja; festryger');

        $html = '<div class="box_form_group" id="'.$type.'Filter"><p for="">'.$label.'</p><select class="form-control 3col active '.$type.'Selection" name="'.$type.'[]" id="'.$type.'" multiple="multiple">';
        $listOptions = $arr[$type];
        if($type == 'gender'){
            foreach ($listOptions as $key=>$option){
                $selected = in_array($key, explode(',', $selectedStr))?'selected':'';
                $html .= '<option value="'.$key.'" '.$selected.'>'.$option.'</option>';
            }
        } else {
            foreach ($listOptions as $key=>$option){
                $selected = in_array($option, explode(',', $selectedStr))?'selected':'';
                $html .= '<option value="'.$option.'" '.$selected.'>'.$option.'</option>';
            }
        }
        $html .= '</select><a href="javascript:void(0);" class="btnClose" onclick="closeFilter(\''.$type.'\')"><i class="i_close"></i></a></div>';
        echo $html;
        exit();
    }

    function uploadPhoto(){
        $upload_path = "./uploads/photo/";

        $user = $this->session->userdata('user');
        //$config['upload_path'] = $this->config->item('root') . "uploads/photo/";
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = '*';
        $config['max_size'] = $this->config->item('maxupload');
        $config['encrypt_name'] = TRUE;  //rename to random string image
        $this->load->library('upload', $config);
        if (isset($_FILES['file']['name'])) {
            if (!$this->upload->do_upload('file')) {
                $response['success'] = 0;
                $response['message'] = $this->upload->display_errors();
                echo json_encode($response);
                exit();
            } else {
                $data = $this->upload->data();
                //Correct the image orientation
                $this->correctImageOrientation($data['full_path']);
                //Update image size
                list($data["image_width"], $data["image_height"]) = getimagesize($data['full_path']);
                //save to db
                $DB['userId'] = $user->id;
                $DB['image'] = $data['file_name'];
                $DB['dt_create'] = time();
                $DB['status'] = 0;
                $imageId = $this->user->savePhoto($DB);

                //resize big image
                if($data["image_width"] > 1200 || $data["image_height"] > 1200){
                    if($data["image_width"] > $data["image_height"]){
                        $scaleIndex = 1200 / $data["image_width"];
                    } else {
                        $scaleIndex = 1200 / $data["image_height"];
                    }

                    $config_resize['image_library'] = 'gd2';
                    $config_resize['source_image'] = $data['full_path'];
                    $config_resize['new_image'] = $data['full_path'];
                    $config_resize['thumb_marker'] = '';
                    $config_resize['create_thumb'] = TRUE;
                    $config_resize['maintain_ratio'] = true;
                    $config_resize['quality'] = "100%";
                    $config_resize['width']         = $data["image_width"] * $scaleIndex;
                    $config_resize['height']       = $data["image_height"] * $scaleIndex;
                    $dim = (intval($data["image_width"]) / intval($data["image_height"])) - ($config_resize['width'] / $config_resize['height']);
                    $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config_resize);

                    $this->image_lib->resize();
                }

                $raw_photo = './uploads/raw_photo/'.$data['file_name'];
                copy($data['full_path'], $raw_photo);

                //create thumb
                $config_resize['image_library'] = 'gd2';
                $config_resize['source_image'] = $data['full_path'];
                $config_resize['new_image'] = './uploads/thumb_photo/';
                $config_resize['thumb_marker'] = '';
                $config_resize['create_thumb'] = TRUE;
                $config_resize['maintain_ratio'] = true;
                $config_resize['quality'] = "100%";
                $config_resize['width']         = 270;
                $config_resize['height']       = 270;
                $dim = (intval($data["image_width"]) / intval($data["image_height"])) - ($config_resize['width'] / $config_resize['height']);
                $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

                $this->load->library('image_lib');
                $this->image_lib->initialize($config_resize);

                if(!$this->image_lib->resize()){ //Resize image
                    redirect("errorhandler"); //If error, redirect to an error page
                }else {
                    $config_crop['image_library'] = 'gd2';
                    $config_crop['source_image'] = './uploads/thumb_photo/' . $data['file_name'];
                    $config_crop['new_image'] = './uploads/thumb_photo/' . $data['file_name'];
                    $config_crop['quality'] = "100%";
                    $config_crop['maintain_ratio'] = FALSE;
                    $config_crop['width'] = 270;
                    $config_crop['height'] = 270;
                    $config_crop['x_axis'] = '0';
                    $config_crop['y_axis'] = '0';

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config_crop);

                    $this->image_lib->crop();

                    //save the raw thumb photo
                    copy('./uploads/thumb_photo/'.$data['file_name'], './uploads/raw_thumb_photo/'.$data['file_name']);
                }

                $response['success'] = 1;
                $response['imageId'] = $imageId;
                $response['message'] = $this->upload->data();
                echo json_encode($response);
                exit();
            }
        }
    }

    function sendEmailAdminToApprovePhoto(){
        $user = $this->session->userdata('user');
        $link = '<a href="'.base_url().'admin/en/mod_images/images?name='.$user->name.'&status=0">Link</a>';
        $content = 'Hej Admin<br /><br />
                        '.$user->name.' har uploadet billede, se venligst dette link for at tjekke det: '.$link.'<br /><br />
                        Med venlig hilsen<br/>
                        <a href="'.base_url().'">Habibidating.dk®</a>';
        $this->general_model->sendEmail(['approvepicture@habibidating.dk'], 'Habibidating.dk - '.$user->name.'har uploadet billede', $content);
        /*$this->session->set_flashdata('message', 'Billedet er sendt til validering og det blir gjordt indenfor 24 timer mvh kundeservice');*/
    }

    function uploadAvatar(){
        $upload_path = "./uploads/user/";

        $user = $this->session->userdata('user');
        //$config['upload_path'] = $this->config->item('root') . "uploads/photo/";
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = '*';
        $config['max_size'] = $this->config->item('maxupload');
        $config['encrypt_name'] = TRUE;  //rename to random string image
        $this->load->library('upload', $config);
        if (isset($_FILES['file']['name'])) {
            if (!$this->upload->do_upload('file')) {
                $response['success'] = 0;
                $response['message'] = $this->upload->display_errors();
                echo json_encode($response);
                exit();
            } else {
                $data = $this->upload->data();
                //Correct the image orientation
                $this->correctImageOrientation($data['full_path']);
                //Update image size
                list($data["image_width"], $data["image_height"]) = getimagesize($data['full_path']);
                //save to db
                $newAvatar = $this->user->getNewAvatar($user->id);
                if($newAvatar != ''){
                    @unlink("./uploads/user/".$newAvatar);
                    @unlink("./uploads/thumb_user/".$newAvatar);
                    @unlink("./uploads/raw_thumb_user/".$newAvatar);
                }
                $this->user->updateAvatar($user->id, $data['file_name'], 1);
                /*$savedUser = $this->user->getUser($user->id);
                $this->session->set_userdata('user', $savedUser);*/
                //create thumb
                $config_resize['image_library'] = 'gd2';
                $config_resize['source_image'] = $data['full_path'];
                $config_resize['new_image'] = './uploads/thumb_user/'.$data['file_name'];
                $config_resize['thumb_marker'] = '';
                $config_resize['create_thumb'] = TRUE;
                $config_resize['maintain_ratio'] = true;
                $config_resize['quality'] = "100%";
                $config_resize['width']         = 500;
                $config_resize['height']       = 500;
                $dim = (intval($data["image_width"]) / intval($data["image_height"])) - ($config_resize['width'] / $config_resize['height']);
                $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

                $this->load->library('image_lib');
                $this->image_lib->initialize($config_resize);

                if(!$this->image_lib->resize()){ //Resize image
                    redirect("errorhandler"); //If error, redirect to an error page
                }else {
                    $config_crop['image_library'] = 'gd2';
                    $config_crop['source_image'] = './uploads/thumb_user/' . $data['file_name'];
                    $config_crop['new_image'] = './uploads/thumb_user/' . $data['file_name'];
                    $config_crop['quality'] = "100%";
                    $config_crop['maintain_ratio'] = FALSE;
                    $config_crop['width'] = 500;
                    $config_crop['height'] = 500;
                    $config_crop['x_axis'] = '0';
                    $config_crop['y_axis'] = '0';

                    $this->image_lib->clear();
                    $this->image_lib->initialize($config_crop);

                    $this->image_lib->crop();

                    $raw_thumb_user = './uploads/raw_thumb_user/'.$data['file_name'];
                    copy($config_crop['new_image'], $raw_thumb_user);

                    $this->updateUserSession($user->id);
                }

                $response['success'] = 1;
                $response['message'] = $this->upload->data();
                $response['user'] = $user;
                echo json_encode($response);
                exit();
            }
        }
    }

    public function updateSearchDataAndCountResult(){
        //Update search session
        $searchKey = $this->input->post('searchKey');
        $searchValue = $this->input->post('searchValue');
        $searchData = $this->session->userdata('searchData');
        $searchData[$searchKey] = $searchValue;
        $this->session->set_userdata('searchData', $searchData);

        //Save search to db
        $user = $this->session->userdata('user');
        $db['search_session'] = json_encode($searchData);
        $this->user->saveUser($db, $user->id);

        //Re-count the number of profiles
        $this->countProfiles();
    }

    public function countProfiles(){
        $user = $this->session->userdata('user');
        $searchData = $this->session->userdata('searchData');
        $ignore = $this->user->getBlockedUserIds($user->id);
        if ($user) {
            $ignore[] = $user->id;
        }
        $numOfProfiles = $this->user->getNum($searchData, $ignore);
        if($numOfProfiles){
            echo $numOfProfiles;
        } else {
            echo '0';
        }
        exit;
    }

    public function loadSearchResult(){
        $offset = $this->input->post('offset');
        $user = $this->session->userdata('user');
        $searchData = $this->session->userdata('searchData');
        $ignore = $this->user->getBlockedUserIds($user->id);
        if ($user) {
            $ignore[] = $user->id;
        }

        $list = $this->user->getBrowsing(12, $offset, $searchData, $ignore);
        $html = '';
        foreach ($list as $profile){
            if($profile->blurIndex == 0 || ($profile->blurIndex != 0 && allowViewAvatar($profile->id))) {
                $avatarFolder = 'raw_thumb_user';
            } else {
                $avatarFolder = 'thumb_user';
            }

            if($this->agent->is_mobile()){
                $footer = '';
            } else {
                $addFriendBtn = $addFavoriteBtn = '';
                if(isFriend($profile->id) == false){
                    $addFriendBtn = '<a href="javascript:void(0);" class="btn btn_addFriend" style="margin-right:4px;" onclick="callAjaxFunction('.$profile->id.', \'requestAddFriendInFavorite\')" id="requestAddFriendBtn'.$profile->id.'">Venneanmodning</a>';
                }
                if(addedToFavorite($profile->id) == false){
                    $addFavoriteBtn = '<a href="javascript:void(0);" class="btn btn_addFriend" onclick="callAjaxFunction('.$profile->id.', \'addFavoriteInPage\')" id="addFavoriteBtn'.$profile->id.'">Tilføj favorit</a>';
                }
                $footer = '<div class="favorites_footer">'.$addFriendBtn.$addFavoriteBtn.'</div>';
            }


            if($profile->login == 1){
                $onlineIcon = '<span class="status"></span>';
            } else {
                $onlineIcon = '';
            }

            $html .= '<div class="col-lg-3 col-md-3 col-sm-3 col-ms-4 col-xs-6">
                        <div class="box_favorites_item">
                            <div class="favorites_img">
                                <a href="'.site_url('user/profile/'.$profile->id.'/'.$profile->name).'">
                                <img src="'.base_url().'uploads/'.$avatarFolder.'/'.$profile->avatar.'" alt="" class="img-responsive">
                                </a>
                                <div class="gallery_number"><i class="i_img"></i> <span>'.countImages($profile->id).'</span></div>
                                '.$footer.'
                            </div>
                            <h5 class="name">'.$profile->name.' '.$onlineIcon.'</h5>
                            <p class="nation">'.$profile->land.'</p>
                            <p class="old">'.printAge($profile->id).' – <span class="area">'.$profile->region.'</span></p>
                        </div>
                    </div>';
        }
        echo $html;exit();
    }

    /*public function checkSession(){
        //Below last_visited should be updated everytime a page is accessed.
        $lastVisitTime = $this->session->userdata("last_visited");
        $tenMinuteBefore = strtotime("-10 minutes");

        echo $lastVisitTime > $tenMinuteBefore ? 1 : 0;
    }*/

    public function checkLoggedInToLogout(){
        $users = $this->user->getLoggedInList();
        if(!empty($users)){
            foreach ($users as $user){
                if($user->expiredSessionTime < time()){
                    $this->user->updateLogin($user->id, 0);
                }
            }
        }
    }

    public function updateUserSession($userId){
        $newUser = $this->user->getUser($userId);
        $this->session->set_userdata('user', $newUser);
    }

    public function deletePhoto(){
        $photoId = $this->input->post('photoId');
        $this->user->deletePhoto($photoId);

        $data['status'] = true;
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function cancelUploadPhoto(){
        $imagesIds = explode(',', $this->input->post('imagesIds'));
        foreach ($imagesIds as $imagesId){
            $this->user->deletePhoto($imagesId);
        }

        $data['status'] = true;
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function deleteMessage(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        //Delete message in comet server
        for($i = 1; $i <= 2; $i++){
            $ch = curl_init();
            if($i == 1){
                $fromId = $user->id;
                $toId = $profileId;
            } else {
                $fromId = $profileId;
                $toId = $user->id;
            }
            curl_setopt($ch, CURLOPT_URL, 'https://api.cometchat.com/v1.8/users/'.$fromId.'/users/'.$toId.'/messages');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

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
            $returnData = json_decode($result);
            foreach ($returnData->data as $item){
                $ch1 = curl_init();

                curl_setopt($ch1, CURLOPT_URL, 'https://api.cometchat.com/v1.8/users/'.$fromId.'/messages/'.$item->id);
                curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Apikey: '.$this->config->item('comet_full_api_key');
                $headers[] = 'Appid: '.$this->config->item('comet_app_id');
                $headers[] = 'Content-Type: application/json';
                curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);

                $result1 = curl_exec($ch1);
                if (curl_errno($ch1)) {
                    echo 'Error:' . curl_error($ch1);
                }
                curl_close($ch1);
            }
        }
        curl_close($ch);

        //Delete message in server
        $this->user->deleteMessage($user->id, $profileId);

        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function deleteVisited(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->deleteVisited($user->id, $profileId);
        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    public function deleteVisitMe(){
        $profileId = $this->input->post('profile_id', true);
        $user = $this->session->userdata('user');
        $this->user->deleteVisitMe($user->id, $profileId);
        $data['status'] = true;

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function correctImageOrientation($filename) {
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($filename);
            if($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if($orientation != 1){
                    $img = imagecreatefromjpeg($filename);
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }
                    if ($deg) {
                        $img = imagerotate($img, $deg, 0);
                    }
                    // then rewrite the rotated image back to the disk as $filename
                    imagejpeg($img, $filename, 95);
                } // if there is some rotation necessary
            } // if have the exif orientation info
        } // if function exists
    }

    public function saveCometAuthToken(){
        $authToken = $this->input->post('authToken');
        $user = $this->session->userdata('user');

        $DB['cometAuthToken'] = $authToken;
        $this->user->saveUser($DB, $user->id);

        //Update the user session
        $newUser = $this->user->getUser($user->id);
        $this->session->set_userdata('user', $newUser);
    }
}
?>