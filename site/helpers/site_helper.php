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
    /*$config['protocol'] = 'smtp';
    $config['smtp_host'] = 'smtp.gmail.com';
    $config['smtp_user'] = 'cuongld0205@gmail.com';
    $config['smtp_pass'] = '0976465090';
    $config['smtp_port'] = 465;
    $config['smtp_crypto'] = 'ssl';*/
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
    eval("\$str = \"$str\";");
    @ob_end_clean();
    /** Send mail */
    try{
        foreach($emails as $email){
            $ci->email->clear();
            $ci->email->to($email);
            if($from){
                $ci->email->from($from,'Zeduuce.com');
            }else{
                $ci->email->from('info@zeduuce.com','Zeduuce.com');
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
    if($user->b2b == 1){
        return false;
    }
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
function customRedirectWithMessage($url, $message){
    $ci = &get_instance();
    $ci->session->set_flashdata('message', $message);
    redirect($url);
}