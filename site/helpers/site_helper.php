<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
function seoUrl($str) {
    //Vietnam
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    $str = preg_replace("/( )/", '-', $str);
    $str = preg_replace("/(\'|\"|`|&|,|\.|\?)/", '', $str);
    $str = preg_replace("/(---|--)/", '-', $str);
    $str = preg_replace('/([^a-z0-9\-\._])/i', '', $str);
    //Danish
    $str = preg_replace("/(æ)/", 'ae', $str);
    $str = preg_replace("/(å)/", 'a', $str);
    $str = preg_replace("/(ø)/", 'o', $str);
    $str = preg_replace("/(Å)/", 'A', $str);
    $str = preg_replace("/(Æ)/", 'AE', $str);
    $str = preg_replace("/(Ø)/", 'O', $str);
    //
    return url_title($str, 'dash', TRUE);
}
function stringLimit($str, $len, $charset='UTF-8'){
    $str = html_entity_decode($str, ENT_QUOTES, $charset);
    if(mb_strlen($str, $charset)> $len){
        $arr = explode(' ', $str);
        $str = mb_substr($str, 0, $len, $charset);
        $arrRes = explode(' ', $str);
        $last = $arr[count($arrRes)-1];
        unset($arr);
        if(strcasecmp($arrRes[count($arrRes)-1], $last)){
            unset($arrRes[count($arrRes)-1]);
        }
        return implode(' ', $arrRes);
    }
    return $str;
}
function html2Txt($str){
    $key = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
    );
    $str = preg_replace($key,'',$str);
    return $str;
}
function stripTagsContent($str, $tags = '', $invert = FALSE){
    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);
    if(is_array($tags) AND count($tags) > 0){
        if($invert == FALSE) {
            return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $str);
        }
        else {
            return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $str);
        }
    }
    elseif($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $str);
    }
    return $str;
}
function checkLogin(){
    $ci = &get_instance();
    $user = $ci->session->userdata('user');
    $isLoginSite = $ci->session->userdata('isLoginSite');
    if($user && $isLoginSite){
        return true;
    }else{
        return false;
    }
}
function userType(){
    $ci = &get_instance();
    $user = $ci->session->userdata('user');
    if($user && empty($user->b2b)){
        $ci->load->database();
        $query = $ci->db->select('type')->where('id', $user->id)->get('user')->row()->type;
        if($query){
            return $query;
        }else{
            return 0;
        }
    }else{
        return 0;
    }
}
function userTypeUser($id=NULL){
    $ci = &get_instance();
    if($id){
        $ci->load->database();
        $query = $ci->db->select('type')->where('id', $id)->get('user')->row()->type;
        if($query){
            return $query;
        }else{
            return 0;
        }
    } else {
        return 0;
    }
}
function priceFormat($price,$symbol="DKK"){
    $decimalPlace = 2;
    $decimalPoint = ',';
    $thousandPoint = '.';
    $string = number_format(round($price, (int)$decimalPlace), (int)$decimalPlace, $decimalPoint, $thousandPoint);
    $string = str_replace(',00',',-',$string);
    if($symbol){
        $string = $string." ".$symbol;
    }
    return $string;
}
function getTimeLeft($time){
    $days = intval($time/24/60/60);
    $remain = $time % 86400;
    $hours = intval($remain/3600);
    $remain = $remain % 3600;
    $mins = intval($remain/60);
    return $hours.' timer '.$mins.' min';
}
function getTimeDifference($time){
    $str = $time;
    $today = time();
    // It returns the time difference in Seconds...
    $time_differnce = $today-$str;
    // To Calculate the time difference in Years...
    $years = 60*60*24*365;
    // To Calculate the time difference in Months...
    $months = 60*60*24*30;
    // To Calculate the time difference in Days...
    $days = 60*60*24;
    // To Calculate the time difference in Hours...
    $hours = 60*60;
    // To Calculate the time difference in Minutes...
    $minutes = 60;
    if(intval($time_differnce/$years) > 1){
        return intval($time_differnce/$years)." år siden";
    }else if(intval($time_differnce/$years) > 0){
        return intval($time_differnce/$years)." år siden";
    }else if(intval($time_differnce/$months) > 1){
        return intval($time_differnce/$months)." måneder siden";
    }else if(intval(($time_differnce/$months)) > 0){
        return intval(($time_differnce/$months))." måned siden";
    }else if(intval(($time_differnce/$days)) > 1){
        return intval(($time_differnce/$days))." dage siden";
    }else if (intval(($time_differnce/$days)) > 0) {
        return intval(($time_differnce/$days))." dag siden";
    }else if (intval(($time_differnce/$hours)) > 1) {
        return intval(($time_differnce/$hours))." timer siden";
    }else if (intval(($time_differnce/$hours)) > 0) {
        return intval(($time_differnce/$hours))." time siden";
    }else if (intval(($time_differnce/$minutes)) > 1) {
        return intval(($time_differnce/$minutes))." minutter siden";
    }else if (intval(($time_differnce/$minutes)) > 0) {
        return intval(($time_differnce/$minutes))." minut siden";
    }else if (intval(($time_differnce)) > 1) {
        return intval(($time_differnce))." sekunder siden";
    }else{
        return "få sekunder siden";
    }
}
function randomPassword(){
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
}
function actionUser($userFrom=NULL, $userTo=NULL, $name=NULL, $type=NULL){
    $ci = &get_instance();
    //Check has action
    /*$query1 = $ci->db->select('*')
                    ->from('user_action')
                    ->where('user_from',$userFrom)
                    ->where('user_to',$userTo)
                    ->where('bl_active',1)
                    ->get()->row();
    $query2 = $ci->db->select('*')
                    ->from('user_action')
                    ->where('user_from',$userTo)
                    ->where('user_to',$userFrom)
                    ->where('bl_active',1)
                    ->get()->row();*/
    if($ci->session->userdata($userFrom.$userTo.$name.$type)){
        //No thing to do
        return true;
    }else{
        //Add new action
        $DB['user_from'] = $userFrom;
        $DB['user_to'] = $userTo;
        $DB['name'] = $name;
        $DB['type'] = $type;
        $DB['dt_create'] = date('Y-m-d H:i:s');
        $DB['bl_active'] = 1;
        $ci->db->insert('user_action',$DB);
        $ci->session->set_userdata($userFrom.$userTo.$name.$type, '1');
        return true;
    }
}
function sendEmail($emails=NULL, $template=NULL, $data=NULL, $from=NULL, $mailType='html'){
    $ci = &get_instance();
    $config['mailtype'] = $mailType;
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.unoeuro.com';
    $config['smtp_user'] = $ci->config->item('sender_email');
    $config['smtp_pass'] = $ci->config->item('email_password');
    $config['smtp_port'] = 587;
    $config['smtp_crypto'] = 'tls';
    $ci->load->library('email', $config);
    $ci->email->set_newline("\r\n");
    $ci->email->initialize($config);
    /** Load email template from database */
    $query = $ci->db->select('*')
        ->from('email_template')
        ->where('code',$template)
        ->where('bl_active',1)
        ->get()->row();
    if(empty($query)){ return false;}
    ob_start();
    extract($data);
    $str = $query->content;
    $str = str_replace('"', "'", $str);
    eval("\$str = \"$str\";");
    @ob_end_clean();

    /** Send mail */
    try{
        foreach($emails as $email){
            $ci->email->clear();
            $ci->email->to($email);
            if($from){
                $ci->email->from($from, 'Habibidating.dk');
            }else{
                $ci->email->from($ci->config->item('sender_email'), 'Habibidating.dk');
            }
            $ci->email->subject($query->subject);
            $ci->email->message($str);
            $ci->email->send();
        }
    }catch(Exception $e){
        return false;
    }
    return true;
}

/**
 * T.Trung
 * @param int $user_id_1
 * @param int $user_id_2
 * @return boolean
 */
function isDated($user_id_1, $user_id_2){
    $ci = &get_instance();
    $query = $ci->db->where('user_id', $user_id_1)->where('invited_user_id', $user_id_2)->get('user_dated')->num_rows();
    $isDated1 = $query?true:false;
    $query = $ci->db->where('user_id', $user_id_2)->where('invited_user_id', $user_id_1)->get('user_dated')->num_rows();
    $isDated2 = $query?true:false;

    $isDated = $isDated1||$isDated2?true:false;
    return $isDated;
}

/**
 * @return bool
 */
function isGoldMember(){
    $ci = &get_instance();
    $user = $ci->session->userdata('user');
    $result = $ci->db->select('type')->from('user')->where('id', $user->id)->get()->row();
    if ($result->type == 2) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param $url
 * @param $message
 * @return a controller
 */
function customRedirectWithMessage($url, $message = ''){
    $ci = &get_instance();
    $ci->session->set_flashdata('message', $message);
    redirect($url);
}

/**
 * @param $id
 * @param $type
 */
function getContent($id, $type = 'content'){
    $ci = &get_instance();
    $content = $ci->db->select('title, content, image')
        ->from('tb_content_static')
        ->where('id', $id)
        ->get()->row();

    switch ($type){
        case 'title':
            return $content->title;
            break;
        case 'content':
            return $content->content;
            break;
        case 'image':
            return $content->image;
            break;
    }
}

function printAge($userId){
    $ci = &get_instance();
    if(!empty($userId)){
        $ci->db->select('day, month, year, birthday')->from('user');
        $ci->db->where("id",$userId);
        $user = $ci->db->get()->row();
        if(!empty($user->birthday)){
            $birthDate = explode("/", $user->birthday);
        } else {
            $birthday = '1/1/'.$user->year;
            $birthDate = explode("/", $birthday);
        }
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        return $age.' år';
    } else {
        return '';
    }
}

function countImages($profileId){
    $ci = &get_instance();
    $imageQuantity = $ci->db->select('COUNT(id) as quantity')
        ->from('tb_user_image')
        ->where('userID', $profileId)
        ->where('status', 1)
        ->get()->row()->quantity;
    return $imageQuantity;
}

function isFriend($profileId, $userId = null){
    $ci = &get_instance();
    if($userId == null){
        $userId = $ci->session->userdata('user')->id;
    }

    $query = $ci->db->select("id")
        ->from('tb_user_friends')
        ->where("(user_from = $userId AND user_to = $profileId) OR (user_from = $profileId AND user_to = $userId)");

    return $query->get()->num_rows()?true:false;
}

function addedToFavorite($profileId){
    $ci = &get_instance();
    $userId = $ci->session->userdata('user')->id;

    $query = $ci->db->select("id")
        ->from('tb_user_favorite')
        ->where("user_from = $userId AND user_to = $profileId");

    return $query->get()->num_rows()?true:false;
}

function inSearch($filterKey, $value){
    $ci = &get_instance();
    $searchData = $ci->session->userdata('searchData');
    if(!empty($searchData[$filterKey])){
        return in_array($value, $searchData[$filterKey]);
    } else {
        return false;
    }
}

function allowViewAvatar($profileId, $userId = null){
    $ci = &get_instance();
    if($userId == null){
        $userId = $ci->session->userdata('user')->id;
    }

    $query = $ci->db->select("viewAvatar")
        ->from('tb_user_friendlist')
        ->where("user_from = $profileId AND user_to = $userId");
    $result = $query->get()->row();
    if(empty($result)){
        return false;
    } else {
        if($result->viewAvatar == 0){
            return false;
        } else {
            return true;
        }
    }
}

function hasBlurredImage($profileId){
    $ci = &get_instance();

    $query = $ci->db->select("id")
        ->from('tb_user_image')
        ->where("userId = $profileId AND blurIndex <> 0");
    $result = $query->get()->row();
    if(empty($result)){
        return false;
    } else {
        return true;
    }
}

function getUser(){
    $ci = &get_instance();
    $user = $ci->session->userdata('user');
    if(!empty($user)){
        $ci->db->select('*')->from('user');
        $ci->db->where("id",$user->id);

        $user = $ci->db->get()->row();
        return $user;
    } else {
        return null;
    }
}

function generateOptionsHTMLInUpdate($type, $name, $selectedValue, $defaultValue = 1){
    $ci = &get_instance();
    $typeArr = $ci->config->item($type);
    $html = '<select name="'.$name.'" class="form-control">';
    if($defaultValue == 1){
        $html .= '<option value="">Ej oplyst</option>';
    }
    foreach($typeArr as $i=>$item){
        $selected = $selectedValue==$item?'selected':'';
        $html .= '<option '.$selected.' value="'.$item.'">'.$item.'</option>';
    }
    $html .= '</select>';
    return $html;
}

function generateOptionsInRangeHTML($name, $from, $to, $selectedValue, $unit = '', $attributes = ''){
    $html = '<select name="'.$name.'" class="form-control" id="'.$name.'" '.$attributes.'>';
    $html .= '<option value="">Ej oplyst</option>';
    for($i = $from; $i <= $to; $i++){
        $selected = $selectedValue==$i?'selected':'';
        $html .= '<option '.$selected.' value="'.$i.'">'.$i.' '.$unit.'</option>';
    }
    $html .= '</select>';
    return $html;
}

function generateSelectInSearch($name){
    $ci = &get_instance();
    $searchData = $ci->session->userdata('searchData');
    $typeArr = $ci->config->item($name);

    $html = '<select class="form-control 3col active regionSelection" name="'.$name.'[]" id="'.$name.'" multiple="multiple">';
    foreach($typeArr as $i=>$item){
        if(!empty($searchData[$name]) && in_array($item, $searchData[$name])){
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $html .= '<option '.$selected.' value="'.$item.'">'.$item.'</option>';
    }
    $html .= '</select>';
    return $html;
}


//Firebase

function addUserToFirebase($user){
    $ci = &get_instance();
    $ci->load->library('firebase');
    $firebase = $ci->firebase->init();
    $db = $firebase->getDatabase();
    $auth = $firebase->getAuth();

    $userProperties = [
        'uid' => $user->id,
        'email' => $user->email,
        'emailVerified' => false,
        'password' => $user->password,
        'displayName' => $user->name,
        'photoUrl' => $ci->config->item('site').'/uploads/thumb_user/'.$user->avatar,
        'disabled' => false
    ];
    $createdUser = $auth->createUser($userProperties);

    $db->getReference('users/'.$user->id)
        ->set([
            'name' => $user->name,
            'avatar' => $ci->config->item('site').'/uploads/thumb_user/'.$user->avatar
        ]);
}

function updateUserInfoToFirebase($userId, $name, $email){
    $ci = &get_instance();
    $ci->load->library('firebase');
    $firebase = $ci->firebase->init();
    $db = $firebase->getDatabase();
    $auth = $firebase->getAuth();

    $uid = $userId;
    $properties = [
        'displayName' => $name,
        'email' => $email
    ];

    $updatedUser = $auth->updateUser($uid, $properties);

    $db->getReference('users/'.$userId)
        ->set([
            'name' => $name
        ]);
}

function updateUserPasswordToFirebase($userId, $password){
    $ci = &get_instance();
    $ci->load->library('firebase');
    $firebase = $ci->firebase->init();
    $db = $firebase->getDatabase();
    $auth = $firebase->getAuth();

    $uid = $userId;
    $properties = [
        'password' => $password
    ];

    $updatedUser = $auth->updateUser($uid, $properties);
}

function getDefaultAvatars(){
    $ci = &get_instance();
    $noAvatarArr = array('no-avatar1.png', 'no-avatar2.png');
    return array_merge($noAvatarArr, $ci->config->item('male_avatar'), $ci->config->item('female_avatar'));
}

function getGenderAvatars(){
    $ci = &get_instance();
    return array_merge($ci->config->item('male_avatar'), $ci->config->item('female_avatar'));
}

function isMobile(){
    $ci = &get_instance();
    return $ci->agent->is_mobile();
}

function checkKiss($userId, &$profiles){
    $ci = &get_instance();

    foreach ($profiles as $key => $profile){
        $ci->db->select('*')
            ->from('user_kisses')
            ->where("(from_user_id = $userId AND to_user_id = ".$profile->id.") OR (from_user_id = ".$profile->id." AND to_user_id = $userId)")
            ->order_by('id DESC')
            ->limit(1, 0);

        $lastKiss = $ci->db->get()->row();
        if($lastKiss->from_user_id == $profile->id){
            $profiles[$key]->returnBlink = "1";
        } else {
            $profiles[$key]->returnBlink = "0";
        }
    }
    return $profiles;
}

function uuid(){
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function sendNotification($userId, $profileId, $type){
    $ci = &get_instance();

    //Get number of unread notification
    $ci->load->model ('user');
    $message = $ci->user->getUnreadMessageQuantity($profileId);
    $blink = $ci->user->getBlinkingQuantity($profileId);
    $friendRequestQuantity = $ci->user->friendRequestQuantity($profileId);
    $rejectRequestQuantity = $ci->user->rejectRequestQuantity($profileId);
    $friend = $ci->user->newFriendQuantity($profileId);
    $numOfUnreadNotification = $message + $blink + $friendRequestQuantity + $rejectRequestQuantity + $friend;

    //Get user name
    $ci->db->select('name')
        ->from('user')
        ->where("id = $userId");
    $name = $ci->db->get()->row()->name;

    $ci->db->select('type')
        ->from('user')
        ->where("id = $profileId");
    $userType = $ci->db->get()->row()->type;

    if($userType == 1){
        if($type == 1){
            $body = 'Du har modtaget et blink';
        } else if($type == 2){
            $body = 'Du har modtaget en venneanmodning';
        } else if($type == 3){
            $body = $name.' har afvist venneanmodning';
        } else if($type == 4){
            $body = $name.' har accepteret venneanmodning';
        } else {
            $body = 'Du har modtaget en besked';
        }
    } else {
        if($type == 1){
            $body = $name.' har sendt et blink';
        } else if($type == 2){
            $body = $name.' har sendt en venneanmodning';
        } else if($type == 3){
            $body = $name.' har afvist venneanmodning';
        } else if($type == 4){
            $body = $name.' har accepteret venneanmodning';
        } else {
            $body = $name.' har sendt en besked';
        }
    }

    //Get tokens
    $ci->db->distinct();
    $ci->db->select('token')
        ->from('user_keys')
        ->where("user_id = $profileId");

    $tokens = $ci->db->get()->result();
    $deviceTokens = array();
    foreach ($tokens as $token){
        $deviceTokens[] = $token->token;
    }
    /*if(empty($deviceTokens)){
        $deviceTokens = array('e8gufFluRx6m2znpQkjjnn:APA91bE2PWIOevjIDUJt5TbbTb-OTVJ3WV5hdAaW7ETeywzfeSOYwYRXTHVoTPCu2PS5O4-xad9jbjWm6L0i_IwLMUIb6Hx3d8kUKxX0T33plTsDPGPN-WtaeaS3Wi1PFf-3Y2g-AoS9');
    }*/

    //Push notification
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
        'registration_ids' => $deviceTokens,
        'notification' => array(
            'title' => 'Habibi Dating',
            'body' => $body,
            'badge' => $numOfUnreadNotification,
            'sound' => 'default'
        ),
        'data' => array (
            'type' => $type, // 1: blink, 2: friend request (received), 3: friend request (rejected), 4: friend, 5: chat
            'count' => $numOfUnreadNotification
        )
    );
    $fields = json_encode ( $fields );

    $headers = array (
        'Authorization: key=' . $ci->config->item('cloud_messaging_key'),
        'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    $result = json_decode($result);
    curl_close ( $ch );
    return $result;
}