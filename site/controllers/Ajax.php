<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('user_model', 'user');
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
        $email = $this->input->post('email', true);
        $id = $this->user->getUser('', $email);
        if ($id) {
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
        for($i = $fromAge + 1; $i <= 70; $i++){
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
        $Login = array('isLoginSite', 'user', 'email', 'password');
        $this->session->unset_userdata($Login);

        setcookie('cc_data', '', -time() + (86400 * 30), "/");

        die('ok');
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

    function loadMoreMessages(){
        $user = $this->session->userdata('user');
        $profileId = $this->input->post('profileId', true);
        $profileName = $this->input->post('profileName', true);
        $total = $this->user->getNumMessages($user->id, $profileId);
        $num = $this->input->post('num', true);

        $messages = $this->user->getMessages($user->id, $profileId, 10, $num);
        $html = '';
        $messages = array_reverse($messages);
        $newNum = $num + 10;
        if($total > $newNum){
            $loadMoreFunction = 'onclick="loadMoreMessages('.$profileId.','.$newNum.', false, \''.$profileName.'\')"';
            $html .= '<li style="text-align: center;" id="loadMoreMessage">
                            <a style="color: #f19906;" href="javascript:void(0)" '.$loadMoreFunction.'>Load earlier messages</a>
                        </li>';
        }
        foreach ($messages as $message){
            if($message->uid == $profileId){
                $html .= '<li class="other">
                            <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$message->avatar.'" /></a>
                            <div class="message">
                                <p>'.$message->message.'</p>
                            </div>
                            <div class="date">Sendt: d. '.date("d/m/Y", $message->dt_create).' kl. '.date("H:i", $message->dt_create).'</div>
                        </li>';
            } else {
                $html .= '<li class="you">
                            <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$message->avatar.'" /></a>
                            <div class="message">
                                <p>'.$message->message.'</p>
                            </div>
                            <div class="date">Sendt: d. '.date("d/m/Y", $message->dt_create).' kl. '.date("H:i", $message->dt_create).'</div>
                        </li>';
            }
        }
        echo $html;
        exit();
    }

    function sendMessage(){
        $user = $this->session->userdata('user');
        if ($user) {
            $DB['user_from'] = $user->id;
            $DB['user_to'] = $this->input->post('user_to');
            $DB['message'] = $this->input->post('message');
            $DB['seen'] = 0;
            $DB['dt_create'] = time();
            $this->user->saveMessage($DB);
            $item = $this->user->getUser($user->id);
            $html = '<li class="you">
                            <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$item->avatar.'" /></a>
                            <div class="message">
                                <p>'.$DB['message'].'</p>
                            </div>
                            <div class="date">Sendt: d. '.date("d/m/Y", $DB['dt_create']).' kl. '.date("H:i", $DB['dt_create']).'</div>
                        </li>';
            echo $html;
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
                $html .= '<li class="other">
                            <a class="user"><img alt="" src="'.base_url().'/uploads/thumb_user/'.$profile->avatar.'" /></a>
                            <div class="message">
                                <p>'.$message->message.'</p>
                            </div>
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

    /*public function loadMoreFavorites($offset){
        $user = $this->session->userdata('user');
        $list = $this->user->getFavorites($user->id, 8, $offset);

    }*/

    public function loadMultiFilter(){
        $type = $this->input->post('type');
        $label = $this->input->post('label');
        $selectedStr = $this->input->post('selectedStr');

        $arr['gender'] = array(1=>'Mand', 2=>'Kvinde');
        $arr['relationship'] = array('Aldrig gift', 'Separeret', 'Skilt', 'Enke/enkemand', 'Det får du at vide senere');
        $arr['children'] = array('Nej', 'Ja; hjemmeboende', 'Ja; udeboende', '1', '2', '3', '3+');
        $arr['ethnic'] = array('Europæisk', 'Afrikansk', 'Latinamerikansk', 'Asiatisk', 'Indisk', 'Arabisk', 'Blandet/andet');
        $arr['religion'] = array('Agnostiker', 'Ateist', 'Buddhist', 'Kristen', 'Kristen/Katolik', 'Jøde', 'Hindu', 'Muslim', 'Spirituel', 'Andet');
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
                //save to db
                $DB['userId'] = $user->id;
                $DB['dt_create'] = time();
                $DB['image'] = $data['file_name'];
                $this->user->savePhoto($DB);

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

                }

                $response['success'] = 1;
                $response['message'] = $this->upload->data();
                echo json_encode($response);
                exit();
            }
        }
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
                //save to db
                $currentAvatar = $this->user->getAvatar($user->id);
                if($currentAvatar != 'no-avatar.jpg'){
                    @unlink("./uploads/user/".$currentAvatar);
                    @unlink("./uploads/thumb_user/".$currentAvatar);
                    @unlink("./uploads/raw_thumb_user/".$currentAvatar);
                }
                $this->user->updateAvatar($user->id, $data['file_name']);
                $savedUser = $this->user->getUser($user->id);
                $this->session->set_userdata('user', $savedUser);
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
                }

                $response['success'] = 1;
                $response['message'] = $this->upload->data();
                echo json_encode($response);
                exit();
            }
        }
    }
}
?>