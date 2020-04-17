<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends MX_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('general_model', 'general');
        $this->language = $this->lang->lang();
        //Get meta data from url
        $this->_meta = $this->general_model->getMetaDataFromUrl();
	}

	public function syncUserToFirebase(){
        $this->load->library('firebase');
        $firebase = $this->firebase->init();
        $db = $firebase->getDatabase();
        $auth = $firebase->getAuth();

	    $users = $this->general->getAllUsers();
	    foreach($users as $user){
            $userProperties = [
            'uid' => $user->id,
            'email' => $user->email,
            'emailVerified' => false,
            'password' => $user->password,
            'displayName' => $user->name,
            'photoUrl' => base_url().'uploads/thumb_user/'.$user->avatar,
            'disabled' => false
            ];
            $createdUser = $auth->createUser($userProperties);

            $db->getReference('users/'.$user->id)
                ->set([
                    'name' => $user->name,
                    'avatar' => base_url().'uploads/thumb_user/'.$user->avatar
                ]);
            echo $user->id.'\n';
        }
    }

    public function syncMessageToFirebase(){

    }
}
?>