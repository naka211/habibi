<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends MX_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('general_model', 'general');
        $this->language = $this->lang->lang();

        //Get meta data from url
        $this->_meta = $this->general_model->getMetaDataFromUrl();
	}

    /*protected function middleware(){
        return array('Checklogin|only:profile,sold');
    }

	function index(){

	}*/

	public function syncUserToComet(){
	    $users = $this->general->getAllUserForComet();
	    foreach($users as $user){
            $params = json_encode(array(
                'uid' => (string)$user->id,
                'name' => $user->name,
                'avatar' => $this->config->item('site').'/uploads/thumb_user/'.$user->avatar
            ));

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api-eu.cometchat.io/v2.0/users');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
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
            curl_close($ch);
        }
	    print_r($result);exit();
    }

    public function syncMessageToCommet(){

    }
}
?>