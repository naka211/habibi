<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Api extends REST_Controller {

    public $application = "A70CD-9DCD8";
    public $auth = "0eoIIdq8ixloOBB8nc0LzpIJwd4NVWSJriNrWWNbD0waW4rYNzkk2yItg1bIesJHEiNFulbWBLwFBjLtJ4uQ";
    public $server_key = 'AAAAHlyQ7Nw:APA91bFqbBT-aCYfBMTCl2egU7f77x1eOgVVqPdNqYcBUjsOnISSZ3D2-EP7MEb3XWERBJr_WDPmu3Gc4NQfi8Hy9UPpZZoOGynXTQJMs-SuHvIfT412YpBVUxJo-fkGiTgg8WKyJhZI';
    function __construct(){
        // Construct the parent class
        parent::__construct();
        $this->load->library('jwt');
        $this->load->library('user_agent');
        //load user model
        $this->load->model('api_model','api');
        $this->load->model('user_model', 'user');

        $this->load->helper('string');
    }

    private function _return($status, $message = '', $data = array()){
        $returnData['status'] = $status;
        $returnData['message'] = $message;
        foreach ($data as $key=>$item){
            $returnData[$key] = $item;
        }
        if($status == true){
            $this->response($returnData, REST_Controller::HTTP_OK);
        } else {
            $this->response($returnData, REST_Controller::HTTP_OK);
        }
    }

    // Intro
    public function login_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $info = $data->info;
        $password = md5($data->password);
        //Login user
        $user = $this->user->getUser('', $info, $password);
        if ($user) {
            if($user->deleted != null){
                $this->_return(false, 'Denne konto er blevet slettet');
            } else {
                //create key in JWT
                $token['id'] = $user->id;
                $token['username'] = $user->name;
                $token['iat'] = time();
                $token['exp'] = time() + 60*60*24;
                $returnKey = $this->jwt->encode($token, $this->config->item('encryption_key'));
                //$this->jwt->decode($data['token'], $this->config->item('encryption_key'), array('HS256'));

                //save key and token to database
                $insertData['user_id'] = $user->id;
                $insertData['key'] = $returnKey;
                $insertData['date_created'] = date('Y-m-d H:i:s');
                $insertData['token'] = $data->token;
                $this->api->saveToken($insertData);

                //set login status
                $this->user->updateLogin($user->id, 1);

                //To update the avatar path
                $user->avatar = base_url().'uploads/thumb_user/'.$user->avatar;

                $this->_return(true, '', array('user'=>$user, 'key'=>$returnKey));
            }
        } else {
            $this->_return(false, 'E-mail / Brugernavn eller adgangskode er forkert, prøv igen!');
        }
    }

    public function logout_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $token = $data->token;

        $this->api->deleteToken($userId, $token);

        //set login status
        $this->user->updateLogin($userId, 0);

        $this->_return(true);

    }

    public function forgotPassword_post(){
        $data = (object)json_decode(file_get_contents("php://input"));

        $user = $this->user->getUser('', $data->email);

        if (empty($user)) {
            $this->_return(false, 'Denne konto er ikke registreret, skal du kontrollere igen.');
        } else {
            $new_password = $this->randomPassword(12, 1, "lower_case,upper_case,numbers");
            $content = 'Kære ' . $user->name . '<br /><br />
                    Din nye adgangskode er: <b>'.$new_password[0].'</b><br /><br />
                    Har du spørgsmål kontakt info@habibidating.dk<br /><br />
                    Med venlig hilsen<br/>
                    <a href="'.base_url().'">Habibidating.dk®</a>';
            $sent = $this->general_model->sendEmail([$user->email], 'Habibidating.dk - Glemt adgangskode', $content);
            if($sent === true){
                $update['password'] = md5($new_password[0]);
                $this->user->saveUser($update, $user->id);
                $this->_return(true, 'En email er sendt til din email, vær venlig at tjekke det, tak.');
            }
        }
    }

    function randomPassword($length, $count, $characters){

        // $length - the length of the generated password
        // $count - number of passwords to be generated
        // $characters - types of characters to be used in the password

        // define variables used within the function
        $symbols = array();
        $passwords = array();
        $used_symbols = '';
        $pass = '';

        // an array of different character types
        $symbols["lower_case"] = 'abcdefghijklmnopqrstuvwxyz';
        $symbols["upper_case"] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $symbols["numbers"] = '1234567890';
        $symbols["special_symbols"] = '!?~@#-_+<>[]{}';

        $characters = explode(",", $characters); // get characters types to be used for the passsword
        foreach ($characters as $key => $value) {
            $used_symbols .= $symbols[$value]; // build a string with all characters
        }
        $symbols_length = strlen($used_symbols) - 1; //strlen starts from 0 so to get number of characters deduct 1

        for ($p = 0; $p < $count; $p++) {
            $pass = '';
            for ($i = 0; $i < $length; $i++) {
                $n = rand(0, $symbols_length); // get a random character from the string with all characters
                $pass .= $used_symbols[$n]; // add the character to the password string
            }
            $passwords[] = $pass;
        }

        return $passwords; // return the generated password
    }

    public function register_post(){
        $data = (object)json_decode(file_get_contents("php://input"));

        //Check created user
        $existEmail = $this->user->getUser('', $data->email);
        $existName = $this->user->getUser('', $data->name);
        if (!empty($existName) || !empty($existEmail)) {
            $this->_return(false, 'Dette email eller navn er i brug');
        }
        /////

        if($data->password != $data->confirmPassword){
            $this->_return(false, 'Genadgangskoden er ikke som kodeord.');
        }
        $data->password = md5($data->password);
        unset($data->confirmPassword);
        if($data->gender == 1){
            $data->avatar = 'no-avatar1.png';
        } else {
            $data->avatar = 'no-avatar2.png';
        }
        $data->type = 1;
        $data->groups = 1;
        $data->os = $this->agent->platform();
        $mobile = $this->agent->mobile();
        if ($mobile) {
            $data->device = 'Mobile';
        } else {
            $data->device = 'Desktop';
        }
        $data->dt_create = date('Y-m-d H:i:s');
        $data->bl_active = 1;

        $id = $this->user->saveUser($data);

        if ($id) {
            //Send email
            $sendEmailInfo['name'] = $data->name;
            $sendEmailInfo['email'] = $data->email;
            $sendEmailInfo['password'] = $data->confirmPassword;
            $emailTo = array($data->email);
            sendEmail($emailTo,'registerFreeMember',$sendEmailInfo,'');

            $user = $this->user->getUser($id);

            //Add user to cometchat
            addUserToFirebase($user);

            $this->_return(true, 'Oprettelsen er gennemført', array('user' => $user));
        } else {
            $this->_return(false, 'Fejl-system, skal du handling igen!');
        }
    }

    public function getOptions_get($type){
        if($type == 'all'){
            $keyArr = array('land', 'region', 'relationship', 'training', 'children', 'religion', 'body', 'smoking', 'business', 'hair_color', 'eye_color', 'job_type', 'zodiac', 'reason');
            foreach ($keyArr as $keyVal){
                $typeArr[$keyVal] = $this->config->item($keyVal);
                /*$typeArrTmp = array();
                foreach ($typeArr[$keyVal] as $key=>$val){
                    $typeArrTmp[$keyVal][$val] = $val;
                }
                $typeArr[$keyVal] = $typeArrTmp[$keyVal];*/
            }
        } else {
            $typeArr = $this->config->item($type);
        }

        $this->_return(true, '', array('options'=>$typeArr));
    }

    //Home
    public function getUsersInHome_get($userId){
        $user = $this->user->getUser($userId);

        //Change login status
        $this->user->updateLogin($user->id, 1);

        $ignore = $this->user->getBlockedUserIds($userId);
        $ignore[] = $userId;

        $randomUsers = $newestUsers = $popularUsers = array();

        $randomUsers = $this->user->getList(4, 0, $user->find_gender, $ignore, null, 'random');
        if(!empty($randomUsers)){
            $this->_setAvatarPath($userId, $randomUsers);
        }

        $newestUsers = $this->user->getList(4, 0, $user->find_gender, $ignore, null, 'newest');
        if(!empty($newestUsers)) {
            $this->_setAvatarPath($userId, $newestUsers);
        }

        $popularUsers = $this->user->getList(4, 0, $user->find_gender, $ignore, null, 'popular');
        if(!empty($popularUsers)) {
            $this->_setAvatarPath($userId, $popularUsers);
        }

        $this->_return(true, '', array('randomUsers'=>$randomUsers, 'newestUsers'=>$newestUsers, 'popularUsers'=>$popularUsers));
    }

    public function getFavorites_get($userId, $page = 1, $perPage = 10){
        $ignore = $this->user->getBlockedUserIds($userId);
        $offset = ($page - 1)*$perPage;
        $users = $this->user->getFavorites($userId, $perPage, $offset, $ignore);
        $this->_setAvatarPath($userId, $users);
        $this->_checkShowingRequestButton($userId, $users);
        if($users){
            foreach ($users as $key => $user){
                $users[$key]->numberOfImages = countImages($user->id);
            }
            $this->_return(true, '', array('users'=>$users));
        } else {
            $this->_return(false, 'Nobody');
        }
    }

    public function removeFavorite_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));

        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->removeFavorite($userId, $profileId);

        $this->_return(true);
    }

    public function sendRequest_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;
        //$user = $this->user->getUser($userId);
        if($this->user->checkExistRequest($userId, $profileId)){
            $this->_return(false, 'Your request is sent.');
        } else {
            if ($userId && $profileId) {
                $DB['user_from'] = $userId;
                $DB['user_to'] = $profileId;
                $DB['status'] = 0;
                $DB['dt_create'] = time();
                $id = $this->user->addRequestAddFriend($DB);
                if($id){
                    //send push notification
                    /* $data['type'] = 'request';
                     $data = json_encode($data);
                     $this->_pushNotification($profileId, 'You have received a request from '.$user->name, $data);*/

                    $this->_return(true, 'Your request is sent.');
                } else {
                    $this->_return(false, 'Can not save to database');
                }
            } else {
                $this->_return(false, 'Invalid userId or profileId');
            }
        }

    }

    public function messageList_get($userId, $page = 1, $perPage = 10){
        $offset = ($page - 1)*$perPage;
        $messageList = $this->user->getUserSent($userId, $perPage, (int)$offset);
        foreach ($messageList as $key => $item){
            if(in_array($item->id, $this->user->getBlockedUserIds($userId))){
                unset($messageList[$key]);
            }
        }
        $this->_setAvatarPath($userId, $messageList);
        if($messageList){
            $this->_return(true, '', array('messageList'=>$messageList));
        } else {
            $this->_return(false, 'No messages');
        }
    }

    public function deleteMessage_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        //Delete message in firebase
        $this->load->library('firebase');
        $firebase = $this->firebase->init();
        $db = $firebase->getDatabase();
        /*$db->getReference('messages/'.$userId.'/'.$profileId)->remove();
        $db->getReference('messages/'.$profileId.'/'.$userId)->remove();*/
        $db->getReference('messages/'.$userId.'/'.$profileId)->set(null);
        $db->getReference('messages/'.$profileId.'/'.$userId)->set(null);

        $storage = $firebase->getStorage();
        $bucket = $storage->getBucket();

        if(!empty($profileId) && !empty($userId)){
            $prefix = $userId.'_'.$profileId;
            $objects = $bucket->objects([
                'prefix' => $prefix
            ]);
            foreach ($objects as $object) {
                $object->delete();
            }

            $prefix = $profileId.'_'.$userId;
            $objects = $bucket->objects([
                'prefix' => $prefix
            ]);
            foreach ($objects as $object) {
                $object->delete();
            }
        }

        //Delete message in server
        $this->user->deleteMessage($userId, $profileId);

        $this->_return(true);
    }

    public function getMessages_get($userId, $profileId, $page = 1, $perPage = 10){
        $offset = ($page - 1)*$perPage;
        $messages = $this->user->getMessages($userId, $profileId, $perPage, $offset);
        $this->_setAvatarPath($userId, $messages);
        if($messages){
            $this->_return(true, '', array('messages'=>$messages));
        } else {
            $this->_return(false, 'No messages');
        }
    }

    public function setSeenMessages_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $this->user->updateSeenMessages($data->userId, $data->profileId);
        $this->_return(true, 'Set');
    }

    public function sendMessage_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;
        $message = $data->message;
        $messageType = $data->messageType;

        //$user = $this->user->getUser($userId);
        $DB['user_from'] = $userId;
        $DB['user_to'] = $profileId;
        $DB['message'] = $message;
        $DB['messageType'] = $messageType;
        $DB['seen'] = 0;
        $DB['dt_create'] = time();
        $id = $this->user->saveMessage($DB);

        if($id){
            //$data['type'] = 'message';
            //$data = json_encode($data);
            //$this->_pushNotification($profileId, 'You have received a message from '.$user->name, $data);

            $this->_return(true);
        } else {
            $this->_return(false, 'Can not send message');
        }

    }

    public function getFriends_get($userId, $keyword = '', $page = 1, $perPage = 10){
        $ignore = $this->user->getBlockedUserIds($userId);
        $offset = ($page - 1)*$perPage;
        $keyword = $keyword == 'all' ? '' : $keyword;
        $total = $this->user->getNumFriends($userId, $ignore, $keyword);
        if($total){
            $users = $this->user->getFriends($userId, $perPage, (int)$offset, $ignore, $keyword);
            $this->_setAvatarPath($userId, $users);
            $this->_return(true, '', array('total'=> (int)$total, 'users'=>$users));
        } else {
            $this->_return(false, 'Nobody');
        }
    }

    public function unFriend_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->cancelRequestAddFriend($userId, $profileId);
        //Delete visiting
        $this->user->deleteVisited($userId, $profileId);
        //Delete visit me
        $this->user->deleteVisitMe($userId, $profileId);
        //Delete blink
        $this->user->deleteBlink($userId, $profileId);
        //Delete message
        $this->user->deleteMessage($userId, $profileId);
        //Remove favorite
        $this->user->removeFavorite($userId, $profileId);
        $this->_return(true);
    }

    public function blockUser_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $status = $this->user->addUserToBlockedList($userId, $profileId);
        if($status == true){
            $this->_return(true);
        } else {
            $this->_return(false, 'Error in block this user');
        }
    }

    public function unBlockUser_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->removeUserToBlockList($userId, $profileId);
        $this->_return(true);
    }

    public function getReceivedRequests_get($userId){
        /*$data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;*/

        $ignore = $this->user->getBlockedUserIds($userId);
        $requests = $this->user->getReceivedRequests($userId, $ignore);

        if($requests){
            $this->_setAvatarPath($userId, $requests);
            $this->_return(true, '', array('requests'=>$requests));
        } else {
            $this->_return(false, 'Ingen anmodning');
        }
    }

    public function getSentRequests_get($userId){
        /*$data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;*/

        $ignore = $this->user->getBlockedUserIds($userId);
        $requests = $this->user->getSentRequests($userId, $ignore);

        if($requests){
            $this->_setAvatarPath($userId, $requests);
            $this->_return(true, '', array('requests'=>$requests));
        } else {
            $this->_return(false, 'Ingen anmodning');
        }
    }

    public function getRejectedRequests_get($userId){
        /*$data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;*/

        $ignore = $this->user->getBlockedUserIds($userId);
        $requests = $this->user->getRejectedRequests($userId, $ignore);

        if($requests){
            $this->_setAvatarPath($userId, $requests);
            $this->_return(true, '', array('requests'=>$requests));
        } else {
            $this->_return(false, 'Ingen afvist');
        }
    }

    public function acceptRequest_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->updateFriendRequest($userId, $profileId, 1);
        $this->user->insertFriendList($userId, $profileId);

        $this->_return(true);
    }

    public function rejectRequest_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->updateFriendRequest($userId, $profileId, 2);

        $this->_return(true);
    }

    public function deleteRequest_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->cancelRequestAddFriend($userId, $profileId);

        $this->_return(true);
    }

    public function getVisitedMeList_get($userId, $page = 1, $perPage = 10){
        $offset = ($page - 1)*$perPage;
        $ignore = $this->user->getBlockedUserIds($userId);
        $users = $this->user->getVisitMe($userId, $perPage, (int)$offset, $ignore);
        if($users){
            checkKiss($userId, $users);
            $this->_setAvatarPath($userId, $users);
            $this->_checkShowingRequestButton($userId, $users);
            $this->_return(true, '', array('users'=>$users));
        } else {
            $this->_return(false, 'Nobody');
        }
    }

    public function getVisitingList_get($userId, $page = 1, $perPage = 10){
        $offset = ($page - 1)*$perPage;
        $ignore = $this->user->getBlockedUserIds($userId);
        $users = $this->user->getVisited($userId, $perPage, (int)$offset, $ignore);
        if($users){
            checkKiss($userId, $users);
            $this->_setAvatarPath($userId, $users);
            $this->_checkShowingRequestButton($userId, $users);
            $this->_return(true, '', array('users'=>$users));
        } else {
            $this->_return(false, 'Nobody');
        }
    }

    public function getReceivedBlink_get($userId, $page = 1, $perPage = 10){
        $offset = ($page - 1)*$perPage;
        $ignore = $this->user->getBlockedUserIds($userId);
        $users = $this->user->getReceivedBlinks($userId, $perPage, (int)$offset, $ignore);
        if($users){
            $this->_setAvatarPath($userId, $users);
            $this->_checkShowingRequestButton($userId, $users);
            $this->_return(true, '', array('users'=>$users));
        } else {
            $this->_return(false, 'No blink');
        }
    }

    public function getSentBlink_get($userId, $page = 1, $perPage = 10){
        $offset = ($page - 1)*$perPage;
        $ignore = $this->user->getBlockedUserIds($userId);
        $users = $this->user->getSentBlinks($userId, $perPage, (int)$offset, $ignore);
        if($users){
            $this->_setAvatarPath($userId, $users);
            $this->_checkShowingRequestButton($userId, $users);
            $this->_return(true, '', array('users'=>$users));
        } else {
            $this->_return(false, 'No blink');
        }
    }

    public function getBlockedList_get($userId, $page = 1, $perPage = 10){
        $offset = ($page - 1)*$perPage;
        $users = $this->user->getBlockList($userId, $perPage, (int)$offset);
        if($users){
            $this->_setAvatarPath($userId, $users);
            $this->_return(true, '', array('users'=>$users));
        } else {
            $this->_return(false, 'Nobody');
        }
    }

    public function blurAvatar_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->setBlurAvatar($userId, $profileId, 0);
        $this->_return(true);
    }

    public function removeBlurAvatar_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->setBlurAvatar($userId, $profileId, 1);
        $this->_return(true);
    }

    public function getSearchResult_post($userId, $page = 1, $perPage = 10){
        $searchData = (array)json_decode(file_get_contents("php://input"));
        $offset = ($page - 1)*$perPage;
        $ignore = $this->user->getBlockedUserIds($userId);
        $ignore[] = $userId;

        //Save search to db
        $db['search_session'] = json_encode($searchData);
        $this->user->saveUser($db, $userId);

        //Re-count the number of profiles
        $numOfProfiles = $this->user->getNum($searchData, $ignore);

        $users = $this->user->getBrowsing($perPage, $offset, $searchData, $ignore);

        if(!empty($users)){
            $this->_setAvatarPath($userId, $users);
            foreach ($users as $key => $user){
                $users[$key]->numberOfImages = countImages($user->id);
            }
            $this->_return(true, '', array('users'=>$users, 'search_session'=>$this->user->getUser($userId)->search_session, 'total'=>$numOfProfiles));
        } else {
            $this->_return(false, 'Nobody', array('search_session'=>$this->user->getUser($userId)->search_session));
        }
    }

    public function getInfo_get($userId){
        $user = $this->user->getUser($userId);

        $user->age = printAge($user->id);

        if(in_array($user->avatar, getDefaultAvatars()) &&  $user->new_avatar == ''){
            $user->allowBlur = '0';
        } else {
            $user->allowBlur = '1';
        }

        $user->avatarPath = base_url().'uploads/user/'.$user->avatar;
        $user->rawThumbAvatarPath = base_url().'uploads/raw_thumb_user/'.$user->avatar;
        $user->thumbAvatarPath = base_url().'uploads/thumb_user/'.$user->avatar;

        if(!empty($user->new_avatar)){
            $user->newAvatarPath = base_url().'uploads/user/'.$user->new_avatar;
            $user->rawThumbNewAvatarPath = base_url().'uploads/raw_thumb_user/'.$user->new_avatar;
            $user->thumbNewAvatarPath = base_url().'uploads/thumb_user/'.$user->new_avatar;
        }

        $this->_return(true, '', array('user'=>$user));
    }

    public function getPhotos_get($userId){
        $photos = $this->user->getPhoto($userId, 0);
        foreach($photos as $key=>$photo){
            $photos[$key]->rawPhotoPath = base_url().'uploads/raw_photo/'.$photos[$key]->image;
            $photos[$key]->photoPath = base_url().'uploads/photo/'.$photos[$key]->image;
            $photos[$key]->rawThumbPhotoPath = base_url().'uploads/raw_thumb_photo/'.$photos[$key]->image;
            $photos[$key]->thumbPhotoPath = base_url().'uploads/thumb_photo/'.$photos[$key]->image;
        }
        $this->_return(true, '', array('photos'=>$photos));
    }

    public function addFavorite_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        if ($userId && $profileId) {
            $DB['user_from'] = $userId;
            $DB['user_to'] = $profileId;
            $DB['created_at'] = time();
            $id = $this->user->addFavorite($DB);
            if($id){
                $this->_return(true);
            } else {
                $this->_return(false, 'Can not save to database');
            }
        } else {
            $this->_return(false, 'Missing info');
        }
    }

    public function sendBlink_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;
        $user = $this->user->getUser($userId);

        if ($userId && $profileId) {
            $DB['from_user_id'] = $userId;
            $DB['to_user_id'] = $profileId;
            $DB['seen'] = 0;
            $DB['send_at'] = time();
            $id = $this->user->sendBlink($DB);
            if($id){
                //add push notification
                /*$data['type'] = 'blink';
                $data = json_encode($data);
                $this->_pushNotification($profileId, 'You have received a blink from '.$user->name, $data);*/

                $this->_return(true);
            } else {
                $this->_return(false, 'Can not save to database');
            }
        } else {
            $this->_return(false, 'Missing info');
        }
    }

    public function reportProfile_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;
        $userName = $data->userName;
        $profileName = $data->profileName;
        $reason = $data->reason;

        $linkProfileName = '<a href="'.base_url().'admin/en/mod_user/user?name='.$profileName.'">'.$profileName.'</a>';

        $content = 'Hej Admin<br /><br />
                        '.$linkProfileName.' er rapporteret af '.$userName.'.<br />
                        Grund: '.$reason.'<br /><br />
                        <a href="'.base_url().'">Habibidating.dk®</a>';
        $sent = $this->general_model->sendEmail(['reportprofile@habibidating.dk'], 'Habibidating.dk - Bruger rapport', $content);
        if($sent){
            $id = $this->user->saveReport($userId, $profileId, $reason);
            if($id == false){
                $this->_return(false, 'Can not save to database');
            } else {
                $this->_return(true);
            }
        } else {
            $this->_return(false, 'Can not send email to admin');
        }
    }

    public function getAmount_get($userId){
        $user = $this->user->getUser($userId);
        if($user->first_payment == 0){
            $amount = 0;
        } else {
            $amount = $this->config->item('price1Month')*100;
        }

        $this->_return(true, '', array('amount'=>$amount));
    }

    public function upgradeSuccess_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;

        $db['package'] = 1;
        $this->user->saveUser($db, $userId);

        $user = $this->user->getUser($userId);
        if($user->package == 1){
            $plusTime = '+3 months';
        } else if($user->package == 3){
            $plusTime = '+3 months';
        } else if($user->package == 6){
            $plusTime = '+6 months';
        } else {
            $plusTime = '+1 day';
        }
        //Update payment
        $DB['first_payment'] = 1;
        $DB['price'] = $data->amount/100;
        $DB['subscriptionid'] = $data->subscriptionid;
        $DB['orderid'] = $data->orderid;
        $DB['type'] = 2;
        $DB['paymenttime'] = time();
        $DB['expired_at'] = strtotime($plusTime, $DB['paymenttime']);
        $DB['cardno']    = $data->cardno;

        //Add to log
        //$this->addPaymentLog($user->id);

        //Send email
        $sendEmailInfo['name']      = $user->name;
        $sendEmailInfo['email']     = $user->email;
        $sendEmailInfo['orderId']   = $DB['orderid'];
        $sendEmailInfo['price']     = $DB['price'].' DKK';
        $sendEmailInfo['expired']   = date('d/m/Y', $DB['expired_at']);
        $emailTo = array($user->email);
        sendEmail($emailTo,'upgradeGoldMember',$sendEmailInfo,'');

        $this->user->saveUser($DB, $userId);

        $this->_return(true);
    }

    public function deletePhotos_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $photoIds = $data->photoIds;

        foreach($photoIds as $key=>$photoId){
            $this->user->deletePhoto($photoId);
        }

        $this->_return(true);
    }

    public function uploadAvatar_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $imageData = $data->imageData;

        $tmp = explode(',', $imageData);
        $imageData = $tmp[1];
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        $ini = substr($tmp[0], 11);
        $type = explode(';', $ini);
        $imageExtension = $type[0];

        $avatarName = random_string('md5').'.'.$imageExtension;
        $avatarPath = './uploads/user/'.$avatarName;
        if(file_put_contents($avatarPath, $image)){
            $newAvatar = $this->user->getNewAvatar($userId);
            if($newAvatar != ''){
                @unlink("./uploads/user/".$newAvatar);
                @unlink("./uploads/thumb_user/".$newAvatar);
                @unlink("./uploads/raw_thumb_user/".$newAvatar);
            }
            $this->user->updateAvatar($userId, $avatarName, 1);
            //Correct the image orientation
            $this->correctImageOrientation($avatarPath);
            //create thumb
            list($imgWidth, $imgHeight) = getimagesize($avatarPath);
            $config_resize['image_library'] = 'gd2';
            $config_resize['source_image'] = $avatarPath;
            $config_resize['new_image'] = './uploads/thumb_user/'.$avatarName;
            $config_resize['thumb_marker'] = '';
            $config_resize['create_thumb'] = TRUE;
            $config_resize['maintain_ratio'] = true;
            $config_resize['quality'] = "100%";
            $config_resize['width']         = 500;
            $config_resize['height']       = 500;
            $dim = (intval($imgWidth) / intval($imgHeight)) - ($config_resize['width'] / $config_resize['height']);
            $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

            $this->load->library('image_lib');
            $this->image_lib->initialize($config_resize);

            if(!$this->image_lib->resize()){ //Resize image
                $this->_return(false, 'Can not resize image');
            } else {
                $config_crop['image_library'] = 'gd2';
                $config_crop['source_image'] = './uploads/thumb_user/' . $avatarName;
                $config_crop['new_image'] = './uploads/thumb_user/' . $avatarName;
                $config_crop['quality'] = "100%";
                $config_crop['maintain_ratio'] = FALSE;
                $config_crop['width'] = 500;
                $config_crop['height'] = 500;
                $config_crop['x_axis'] = '0';
                $config_crop['y_axis'] = '0';

                $this->image_lib->clear();
                $this->image_lib->initialize($config_crop);

                $this->image_lib->crop();

                $raw_thumb_user = './uploads/raw_thumb_user/'.$avatarName;
                copy($config_crop['new_image'], $raw_thumb_user);

                $user = $this->user->getUser($userId);
                $this->_sendEmailAdminToApproveAvatar($user->name);

                $this->_return(true);
            }
        } else {
            $this->_return(false, 'Can not upload avatar');
        }
    }

    public function saveAvatar_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $blurIndex = $data->blurIndex;
        $imageData = $data->imageData;

        $tmp = explode(',', $imageData);
        $imageData = $tmp[1];
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        $newAvatar = $this->user->getNewAvatar($userId);
        if(!empty($newAvatar)){
            $avatar = $newAvatar;
        } else {
            $avatar = $this->user->getAvatar($userId);
        }
        if(!in_array($avatar, getDefaultAvatars())){
            $thumb_user = './uploads/thumb_user/'.$avatar;
            if(file_put_contents($thumb_user, $image)){
                $this->user->updateBlurIndex($userId, $blurIndex);
                $this->_return(true);
            } else {
                $this->_return(false, 'Can not upload image');
            }
        } else {
            $this->_return(false, 'Can not save default avatar');
        }

    }

    public function selectAvatarFromGallery_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $imageName = $data->imageName;

        $user = $this->user->getUser($userId);

        $newAvatar = $this->user->getNewAvatar($user->id);
        if($newAvatar != ''){
            @unlink("./uploads/user/".$newAvatar);
            @unlink("./uploads/thumb_user/".$newAvatar);
            @unlink("./uploads/raw_thumb_user/".$newAvatar);
        }
        $this->user->updateAvatar($user->id, $imageName, 1);
        //Sending approve email
        $this->_sendEmailAdminToApproveAvatar($user->name);

        copy('./uploads/photo/'.$imageName, './uploads/user/'.$imageName);
        //create thumb
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = './uploads/user/'.$imageName;
        $config_resize['new_image'] = './uploads/thumb_user/'.$imageName;
        $config_resize['thumb_marker'] = '';
        $config_resize['create_thumb'] = TRUE;
        $config_resize['maintain_ratio'] = true;
        $config_resize['quality'] = "100%";
        $config_resize['width']         = 500;
        $config_resize['height']       = 500;
        list($width, $height) = getimagesize($config_resize['source_image']);
        $dim = (intval($width) / intval($height)) - ($config_resize['width'] / $config_resize['height']);
        $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

        $this->load->library('image_lib');
        $this->image_lib->initialize($config_resize);

        if(!$this->image_lib->resize()){ //Resize image
            $this->_return(false, 'Can not resize image');
        } else {
            $config_crop['image_library'] = 'gd2';
            $config_crop['source_image'] = './uploads/thumb_user/' . $imageName;
            $config_crop['new_image'] = './uploads/thumb_user/' . $imageName;
            $config_crop['quality'] = "100%";
            $config_crop['maintain_ratio'] = FALSE;
            $config_crop['width'] = 500;
            $config_crop['height'] = 500;
            $config_crop['x_axis'] = '0';
            $config_crop['y_axis'] = '0';

            $this->image_lib->clear();
            $this->image_lib->initialize($config_crop);

            $this->image_lib->crop();

            $raw_thumb_user = './uploads/raw_thumb_user/'.$imageName;
            copy($config_crop['new_image'], $raw_thumb_user);

            $this->_return(true, 'The new avatar is set.');
        }
    }

    public function deleteAvatar_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;

        $user = $this->user->getUser($userId);
        $allAvatar = $this->user->getAllAvatar($userId);
        if(!empty($allAvatar->new_avatar)){
            @unlink("./uploads/user/".$allAvatar->new_avatar);
            @unlink("./uploads/thumb_user/".$allAvatar->new_avatar);
            @unlink("./uploads/raw_thumb_user/".$allAvatar->new_avatar);
        } else {
            if($user->gender == 1){
                $noAvatarName = 'no-avatar1.png';
            } else {
                $noAvatarName = 'no-avatar2.png';
            }
            $this->user->setCurrentAvatarFromPre($userId, $allAvatar->pre_avatar, $noAvatarName);

            $defaultAvatarArr = getDefaultAvatars();
            if(!in_array($allAvatar->avatar, $defaultAvatarArr)){
                @unlink("./uploads/user/".$allAvatar->avatar);
                @unlink("./uploads/thumb_user/".$allAvatar->avatar);
                @unlink("./uploads/raw_thumb_user/".$allAvatar->avatar);
            }
        }

        $this->_return(true, 'The avatar is deleted.');
    }

    public function uploadPhoto_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $imageData = $data->imageData;

        $tmp = explode(',', $imageData);
        $imageData = $tmp[1];
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        $ini = substr($tmp[0], 11);
        $type = explode(';', $ini);
        $imageExtension = $type[0];

        $photoName = random_string('md5').'.'.$imageExtension;
        $photoPath = './uploads/photo/'.$photoName;
        if(file_put_contents($photoPath, $image)){
            $DB['userId'] = $userId;
            $DB['image'] = $photoName;
            $DB['dt_create'] = time();
            $DB['status'] = 0;
            $this->user->savePhoto($DB);

            //Correct the image orientation
            $this->correctImageOrientation($photoPath);

            list($imgWidth, $imgHeight) = getimagesize($photoPath);
            //resize big image
            if($imgWidth > 1500 || $imgHeight > 1500){
                if($imgWidth > $imgHeight){
                    $scaleIndex = 1500 / $imgWidth;
                } else {
                    $scaleIndex = 1500 / $imgHeight;
                }

                $config_resize['image_library'] = 'gd2';
                $config_resize['source_image'] = $photoPath;
                $config_resize['new_image'] = $photoPath;
                $config_resize['thumb_marker'] = '';
                $config_resize['create_thumb'] = TRUE;
                $config_resize['maintain_ratio'] = true;
                $config_resize['quality'] = "100%";
                $config_resize['width']         = $imgWidth * $scaleIndex;
                $config_resize['height']       = $imgHeight * $scaleIndex;
                $dim = (intval($imgWidth) / intval($imgHeight)) - ($config_resize['width'] / $config_resize['height']);
                $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

                $this->load->library('image_lib');
                $this->image_lib->initialize($config_resize);

                $this->image_lib->resize();
            }

            $raw_photo = './uploads/raw_photo/'.$photoName;
            copy($photoPath, $raw_photo);

            //create thumb
            list($imgWidth, $imgHeight) = getimagesize($photoPath);
            $config_resize['image_library'] = 'gd2';
            $config_resize['source_image'] = $photoPath;
            $config_resize['new_image'] = './uploads/thumb_photo/'.$photoName;
            $config_resize['thumb_marker'] = '';
            $config_resize['create_thumb'] = TRUE;
            $config_resize['maintain_ratio'] = true;
            $config_resize['quality'] = "100%";
            $config_resize['width']         = 270;
            $config_resize['height']       = 270;
            $dim = (intval($imgWidth) / intval($imgHeight)) - ($config_resize['width'] / $config_resize['height']);
            $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

            $this->load->library('image_lib');
            $this->image_lib->initialize($config_resize);

            if(!$this->image_lib->resize()){ //Resize image
                $this->_return(false, 'Can not resize image');
            } else {
                $config_crop['image_library'] = 'gd2';
                $config_crop['source_image'] = './uploads/thumb_photo/' . $photoName;
                $config_crop['new_image'] = './uploads/thumb_photo/' . $photoName;
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
                copy('./uploads/thumb_photo/'.$photoName, './uploads/raw_thumb_photo/'.$photoName);

                $user = $this->user->getUser($userId);
                $this->_sendEmailAdminToApprovePhoto($user->name);

                $this->_return(true);
            }
        } else {
            $this->_return(false, 'Can not upload image');
        }
    }

    public function savePhoto_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $imageName = $data->imageName;
        $blurIndex = $data->blurIndex;
        $imageData = $data->imageData;

        $tmp = explode(',', $imageData);
        $imageData = $tmp[1];
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        $photoLink = './uploads/photo/'.$imageName;
        if(file_put_contents($photoLink, $image)){
            $this->user->updateBlurIndexForPhoto($imageName, $blurIndex);

            //create thumb
            list($imgWidth, $imgHeight) = getimagesize($photoLink);

            $config_resize['image_library'] = 'gd2';
            $config_resize['source_image'] = $photoLink;
            $config_resize['new_image'] = './uploads/thumb_photo/'.$imageName;
            $config_resize['thumb_marker'] = '';
            $config_resize['create_thumb'] = TRUE;
            $config_resize['maintain_ratio'] = true;
            $config_resize['quality'] = "100%";
            $config_resize['width']         = 270;
            $config_resize['height']       = 270;
            $dim = (intval($imgWidth) / intval($imgHeight)) - ($config_resize['width'] / $config_resize['height']);
            $config_resize['master_dim'] = ($dim > 0)? "height" : "width";

            $this->load->library('image_lib');
            $this->image_lib->initialize($config_resize);

            if(!$this->image_lib->resize()){ //Resize image
                $this->_return(false, 'Can not resize photo');
            }else {
                $config_crop['image_library'] = 'gd2';
                $config_crop['source_image'] = './uploads/thumb_photo/' . $imageName;
                $config_crop['new_image'] = './uploads/thumb_photo/' . $imageName;
                $config_crop['quality'] = "100%";
                $config_crop['maintain_ratio'] = FALSE;
                $config_crop['width'] = 270;
                $config_crop['height'] = 270;
                $config_crop['x_axis'] = '0';
                $config_crop['y_axis'] = '0';

                $this->image_lib->clear();
                $this->image_lib->initialize($config_crop);

                $this->image_lib->crop();

                $this->_return(true);
            }
        } else {
            $this->_return(false, 'Can not upload image');
        }
    }

    public function checkName_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $name = $data->name;

        $exist = $this->user->checkUser($userId, $name);
        if ($exist) {
            $this->_return(false, 'Dette burger navn er I brug');
        } else {
            $this->_return(true);
        }
    }

    public function checkEmail_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $email = $data->email;

        $exist = $this->user->checkUser($userId, null, $email);
        if ($exist) {
            $this->_return(false, 'Denne mail er I brug');
        } else {
            $this->_return(true);
        }
    }

    public function updateBasicInfo_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        if(empty($data->password) || $this->_checkPassword($data->userId, $data->password) == false){
            $this->_return(false, 'Forkert adgangskode');
        }
        $userId = $data->userId;
        unset($data->password);
        unset($data->userId);
        $data->birthday = $data->day . '/' . $data->month . '/' . $data->year;
        $status = $this->user->saveUser($data, $userId);
        if($status != false){
            $this->_return(true);
        } else {
            $this->_return(false, 'Can not update information');
        }
    }

    public function updateExtraInfo_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        if(empty($data->password) || $this->_checkPassword($data->userId, $data->password) == false){
            $this->_return(false, 'Forkert adgangskode');
        }
        $userId = $data->userId;
        unset($data->password);
        unset($data->userId);
        $status = $this->user->saveUser($data, $userId);
        if($status != false){
            $this->_return(true);
        } else {
            $this->_return(false, 'Can not update information');
        }
    }

    public function updateInfo_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        if(empty($data->password) || $this->_checkPassword($data->userId, $data->password) == false){
            $this->_return(false, 'Forkert adgangskode');
        }
        $userId = $data->userId;
        unset($data->password);
        unset($data->userId);
        $data->birthday = $data->day . '/' . $data->month . '/' . $data->year;
        $status = $this->user->saveUser($data, $userId);
        //Update user to firebase
        updateUserInfoToFirebase($userId, $data->name, $data->email);
        if($status != false){
            $this->_return(true, 'Opdateret med success');
        } else {
            $this->_return(false, 'Can not update information');
        }
    }

    public function changeCardSuccess_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $subscriptionid = $data->subscriptionid;
        $cardno = $data->cardno;
        //Update card info
        $DB['subscriptionid'] = $subscriptionid;
        $DB['cardno']    = $cardno;
        if($this->user->saveUser($DB, $userId)){
            $this->_return(true);
        } else {
            $this->_return(false, 'Can not update information');
        }
    }

    public function changePassword_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        /*$password = $data->password;*/
        $newPassword = $data->newPassword;

        /*if(empty($password) || $this->_checkPassword($userId, $password) == false){
            $this->_return(false, 'The password is not match.');
        }*/

        $data = new stdClass();
        $data->password = md5($newPassword);
        //Update user password to firebase
        updateUserPasswordToFirebase($userId, $data->password);
        if($this->user->saveUser($data, $userId)){
            $this->_return(true, 'Den nye adgangskode ændres');
        } else {
            $this->_return(false, 'Kan ikke opdatere nyt kodeord');
        }
    }

    public function changeChatStatus_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $status = $data->status;

        $result = $this->db->set('chat', $status)
            ->where("id", $userId)
            ->update("tb_user");
        if($result == false){
            $this->_return(false, 'Can not update chatting status');
        } else {
            $this->_return(true);
        }
    }

    public function setWithdrawStatus_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $password = $data->password;
        $status = $data->status;

        if($status == 1){
            if(empty($password) || $this->_checkPassword($userId, $password) == false){
                $this->_return(false, 'Forkert adgangskode');
            }
        }

        $db['stand_by_payment'] = $status;
        if($this->user->saveUser($db, $userId)){
            $this->_return(true);
        } else {
            $this->_return(false, 'Can not set the status');
        }
    }

    public function setDeactivationStatus_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $password = $data->password;
        $status = $data->status;

        if($status == 1){
            if(empty($password) || $this->_checkPassword($userId, $password) == false){
                $this->_return(false, 'Forkert adgangskode');
            }
        }

        $db['deactivation'] = $status;
        if($this->user->saveUser($db, $userId)){
            $this->_return(true);
        } else {
            $this->_return(false, 'Can not set the status');
        }
    }

    public function deleteAccount_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $password = $data->password;

        if(empty($password) || $this->_checkPassword($userId, $password) == false){
            $this->_return(false, 'Forkert adgangskode');
        }

        $db['deleted'] = time();
        if($this->user->saveUser($db, $userId)){
            $this->_return(true);
        } else {
            $this->_return(false, 'Can not delete this account');
        }
    }

    private function _allowViewAvatar($userId, $profileId){
        $result = $this->api->checkFriend($userId, $profileId);

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

    private function _setAvatarPath($userId, &$profiles){
        foreach($profiles as $i => $profile){
            if($profile->blurIndex == 0 || ($profile->blurIndex != 0 && $this->_allowViewAvatar($userId, $profile->id))){
                $profiles[$i]->avatarPath = base_url().'uploads/raw_thumb_user/'.$profile->avatar;
            } else {
                $profiles[$i]->avatarPath = base_url().'uploads/thumb_user/'.$profile->avatar;
            }
        }
    }

    private function _sendEmailAdminToApproveAvatar($userName){
        $link = '<a href="'.base_url().'admin/en/mod_user/user?name='.$userName.'">Link</a>';
        $content = 'Hej Admin<br /><br />
                        '.$userName.' har uploadet en avatar, se venligst dette link for at tjekke det: '.$link.'<br /><br />
                        Med venlig hilsen<br/>
                        <a href="'.base_url().'">Habibidating.dk®</a>';
        $this->general_model->sendEmail(['approvepicture@habibidating.dk'], 'Habibidating.dk - '.$userName.'har uploadet en avatar', $content);
    }

    private function _sendEmailAdminToApprovePhoto($userName){
        $link = '<a href="'.base_url().'admin/en/mod_images/images?name='.$userName.'&status=0">Link</a>';
        $content = 'Hej Admin<br /><br />
                        '.$userName.' har uploadet billede, se venligst dette link for at tjekke det: '.$link.'<br /><br />
                        Med venlig hilsen<br/>
                        <a href="'.base_url().'">Habibidating.dk®</a>';
        $this->general_model->sendEmail(['approvepicture@habibidating.dk'], 'Habibidating.dk - '.$userName.'har uploadet billede', $content);
    }
    private function _checkPassword($userId, $password){
        $correctUser = $this->user->getUser($userId, null, md5($password));
        if(empty($correctUser)){
            return false;
        } else {
            return true;
        }
    }

    private function _checkShowingRequestButton($userId, &$profiles){
        foreach ($profiles as $key => $profile){
            $profiles[$key]->showRequestButton = isFriend($profiles[$key]->id, $userId) ? false : true;
            //Get friend status
            $status = $this->user->checkStatus($userId, $profile->id);
            $profiles[$key]->friendStatus = $status->isFriend;
        }
    }

    private function _pushNotification($profileId, $msg, $data){
        $url = 'https://cp.pushwoosh.com/json/1.3/createTargetedMessage';
        $send['request'] = array('auth' => $this->auth, 'send_date'=>'now', 'content'=>$msg, 'devices_filter'=>'A("'.$this->application.'") * (T("userId", EQ, '.$profileId.') + T("userId", EQ, '.$profileId.'))', 'data'=>$data);

        $request = json_encode($send);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $response;
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

    public function setToFree_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;

        $db['type'] = 1;
        if($this->user->saveUser($db, $userId)){
            $this->_return(true);
        } else {
            $this->_return(false, 'Can not set the status');
        }
    }

    public function getFriendStatus_get($userId = null, $profileId = null){
        $status = $this->user->checkStatus($userId, $profileId);
        $friendStatus = $status->isFriend;
        $favoriteStatus = $status->isFavorite ? '1' : '0';
        $blockedStatus = $status->isBlocked ? '1' : '0';

        //Allow to view avatar or not
        $profile = $this->user->getUser($profileId);
        if($profile->blurIndex == 0 || ($profile->blurIndex != 0 && allowViewAvatar($profile->id, $userId))) {
            $avatarPath = base_url().'uploads/raw_thumb_user/'.$profile->avatar;
        } else {
            $avatarPath = base_url().'uploads/thumb_user/'.$profile->avatar;
        }

        //Allow to view photos or not
        $photos = $this->user->getPhoto($profileId, 1);
        $photoLinks = array();
        foreach($photos as $key=>$photo){
            if(hasBlurredImage($profile->id) && allowViewAvatar($profile->id, $userId)) {
                $photoLinks[$key]->photoPath = base_url().'uploads/raw_photo/'.$photos[$key]->image;
                $photoLinks[$key]->thumbPhotoPath = base_url().'uploads/raw_thumb_photo/'.$photos[$key]->image;
            } else {
                $photoLinks[$key]->photoPath = base_url().'uploads/photo/'.$photos[$key]->image;
                $photoLinks[$key]->thumbPhotoPath = base_url().'uploads/thumb_photo/'.$photos[$key]->image;
            }
        }

        $this->_return(true, '', array('friendStatus'=>$friendStatus, 'favorite'=>$favoriteStatus, 'blocked'=>$blockedStatus, 'avatarPath'=>$avatarPath, 'photos'=>$photoLinks));
    }

    public function deleteVisited_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->deleteVisited($userId, $profileId);
        $this->_return(true);
    }

    public function deleteVisitMe_delete(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->deleteVisitMe($userId, $profileId);
        $this->_return(true);
    }

    public function getNewNotification_get($userId = null){
        //Update the session time
        $this->user->setExpireSessionTime($userId);

        $message = $this->user->getUnreadMessageQuantity($userId);
        $blink = $this->user->getBlinkingQuantity($userId);
        $friendRequestQuantity = $this->user->friendRequestQuantity($userId);
        $rejectRequestQuantity = $this->user->rejectRequestQuantity($userId);
        $request = $friendRequestQuantity + $rejectRequestQuantity;
        $friend = $this->user->newFriendQuantity($userId);

        $this->_return(true, '', array('messageCount' => $message, 'blinkCount' => $blink, 'requestCount' => $friendRequestQuantity, 'rejectCount' => $rejectRequestQuantity, 'totalRequestCount' => $request, 'friendCount' => $friend));
    }

    /*public function loadCometMessages_get($userId, $profileId){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api-eu.cometchat.io/v2.0/users/'.$userId.'/users/'.$profileId.'/messages');
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
    }*/

    public function getDefaultAvatars_get(){
        $maleArr = array();
        foreach($this->config->item('male_avatar') as $key => $item){
            $maleArr[$key]['imageName'] = $item;
            $maleArr[$key]['src'] = site_url().'uploads/user/'.$item;
        }

        $femaleArr = array();
        foreach($this->config->item('female_avatar') as $key => $item){
            $femaleArr[$key]['imageName'] = $item;
            $femaleArr[$key]['src'] = site_url().'uploads/user/'.$item;
        }

        $this->_return(true, '', array('male'=> $maleArr, 'female'=>$femaleArr));
    }

    public function selectAvatarFromList_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $imageName = $data->imageName;

        $allAvatar = $this->user->getAllAvatar($userId);

        $this->user->setPreAvatarFromCurrent($userId);
        if(!empty($allAvatar->pre_avatar)){
            if(!in_array($allAvatar->pre_avatar, getDefaultAvatars())){
                @unlink("./uploads/user/".$allAvatar->pre_avatar);
                @unlink("./uploads/thumb_user/".$allAvatar->pre_avatar);
                @unlink("./uploads/raw_thumb_user/".$allAvatar->pre_avatar);
            }
        }

        if(!empty($allAvatar->new_avatar)){
            @unlink("./uploads/user/".$allAvatar->new_avatar);
            @unlink("./uploads/thumb_user/".$allAvatar->new_avatar);
            @unlink("./uploads/raw_thumb_user/".$allAvatar->new_avatar);
        }

        $this->user->updateAvatar($userId, $imageName);

        $this->_return(true, 'The new avatar is set.');
    }

    public function addVisitingLog_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;
        $profileId = $data->profileId;

        $this->user->addToVisiting($userId, $profileId);

        $this->_return(true, 'Ok');
    }

    public function changeLoginStatus_put(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $userId = $data->userId;

        //Change login status
        $this->user->updateLogin($userId, 0);

        $this->_return(true);
    }

    public function sendContact_post(){
        $data = (object)json_decode(file_get_contents("php://input"));
        $name = $data->name;
        $phone = $data->phone;
        $email = $data->email;
        $message = $data->message;

        $content = 'Kære Admin<br /><br />
                        Du har en forespørgsel fra kontaktformularen:<br /><br />
                        Navn: '.$name.'<br /><br />
                        Email: '.$email.'<br /><br />
                        Telefon: '.$phone.'<br /><br />
                        Besked: '.$message.'<br /><br />
                        Habibi Team - Habibidating.dk';
        $this->general_model->sendEmail(['info@habibidating.dk'], 'Habibidating.dk - En besked fra kontaktformularen', $content);
        $this->_return(true, '', array('message'=> "Tak for din henvendelse.\nVi kigger på det fremsendte og vender retur inden for 24 timer.\n\nMvh. Habibidating.dk"));
    }
}
