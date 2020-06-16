<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Chat extends MX_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('general_model', 'general');
        $this->language = $this->lang->lang();
        //Get meta data from url
        $this->_meta = $this->general_model->getMetaDataFromUrl();
	}

	public function syncUsersToFirebase(){
        $this->load->library('firebase');
        $firebase = $this->firebase->init();
        $db = $firebase->getDatabase();
        $auth = $firebase->getAuth();

	    $users = $this->general->getAllUsers();
	    $serverLink = 'https://www.habibidating.dk/';
	    foreach($users as $user){
            $userProperties = [
            'uid' => $user->id,
            'email' => $user->email,
            'emailVerified' => false,
            'password' => $user->password,
            'displayName' => $user->name,
            'photoUrl' => $serverLink.'uploads/thumb_user/'.$user->avatar,
            'disabled' => false
            ];
            $createdUser = $auth->createUser($userProperties);

            $db->getReference('users/'.$user->id)
                ->set([
                    'name' => $user->name,
                    'avatar' => $serverLink.'uploads/thumb_user/'.$user->avatar
                ]);
            echo $user->id."\n";
        }
    }

    public function syncMessagesToFirebase(){
        $this->load->library('firebase');
        $firebase = $this->firebase->init();
        $db = $firebase->getDatabase();

        $messages = $this->general->getAllMessages();
        foreach($messages as $key => $message) {
            $message->user_from = (string)$message->user_from;
            $message->user_to = (string)$message->user_to;
            $newPostKey = $db->getReference('messages/' . $message->user_from . '/' . $message->user_to)->push()->getKey();

            $messageData = ['message' => $message->message,
                'type' => 'text',
                'messageId' => $newPostKey,
                'recipient' => $message->user_to,
                'sender' => $message->user_from,
                'time' => (float)$message->dt_create];
            $db->getReference('messages/' . $message->user_from . '/' . $message->user_to . '/' . $newPostKey)->update($messageData);
            $db->getReference('messages/' . $message->user_to . '/' . $message->user_from . '/' . $newPostKey)->update($messageData);

            echo $message->id."\n";
        }
    }
}
?>