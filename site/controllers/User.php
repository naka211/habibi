<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends MX_Controller
{
    private $language = "";
    private $message = "";
    private $_meta = null;

    function __construct()
    {
        parent::__construct();
        $this->session->set_userdata(array('url' => uri_string()));
        $this->load->model('user_model', 'user');
        $this->load->library('user_agent');
        $this->language = $this->lang->lang();

        //Get meta data from url
        $this->_meta = $this->general_model->getMetaDataFromUrl();

        $this->load->library('session');
        $this->session->set_userdata('last_visited', time());
        $this->setExpireSessionTime();

    }

    protected function middleware(){
        return array('Checklogin|only:profile, friendRequests, myPhoto, uploadPhoto, friends, sentBlinks, messages, receivedBlinks, favorites, update, addFavorite, removeFavorite, upgrade, blocked, searching, editAvatar, visitMe, visited, start, editphoto, blockList', 'Checkgold|only:visitme');
    }

    function setExpireSessionTime(){
        $user = $this->session->userdata('user');
        if($user){
            $this->user->setExpireSessionTime($user->id);
        }
    }

    public function start(){
        $data = $ignore = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Start');
        $user = $this->session->userdata('user');
        $searchData = $this->session->userdata('searchData');

        $ignore = $this->user->getBlockedUserIds($user->id);
        $ignore[] = $user->id;

        $randomUsers = $this->user->getList(4, 0, $user->find_gender, $ignore, null, 'random');

        $newestUsers = $this->user->getList(10, 0, $user->find_gender, $ignore, null, 'newest');

        $popularUsers = $this->user->getList(10, 0, $user->find_gender, $ignore, null, 'popular');

        $data['randomUsers'] = $randomUsers;
        $data['newestUsers'] = $newestUsers;
        $data['popularUsers'] = $popularUsers;
        $data['searchData'] = $searchData;
        $data['user'] = $user;
        $data['page'] = 'user/start';
        $this->load->view('templates', $data);
    }

    function index(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        if (!checkLogin()) {
            redirect(site_url(''));
        }
        $user = $this->session->userdata('user');
        $data['user'] = $this->user->getUser($user->id);
        $data['images'] = $this->user->getPhoto($data['user']->id, 0);
        $data['isMobile'] = $this->agent->is_mobile();

        $data['page'] = 'user/index';
        $this->load->view('templates', $data);
    }

    public function redirectToProfile($id, $name){
        $user = $this->session->userdata('user');

        $this->user->disableStatus($id, $user->id, 'SeeMore3Times');

        redirect(site_url('/user/profile/'.$id.'/'.$name));
    }

    function profile($id){
        $data = array();
        $data['user'] = $this->session->userdata('user');
        $data['profile'] = $this->user->getUser($id);

        $this->user->addMeta($this->_meta, $data, 'Habibi - '.$data['profile']->name);

        //Add action to log
        $this->user->addToVisiting($data['user']->id, $id);

        $images = $this->user->getPhoto($id, 1);
        if ($images) {
            /*$data['avatar'] = $photo[0]->image;*/
            $data['images'] = $images;
        } else {
            $data['images'] = "";
        }

        $data['status'] = $this->user->checkStatus($data['user']->id, $id);
        if(isGoldMember()){
            $data['messages'] = $this->user->getMessages($data['user']->id, $id, 10, 0);
        }

        $data['page'] = 'user/profile';
        $this->load->view('templates', $data);
    }

    /** Photo*/
    function uploadPhoto(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Mine billeder');

        $data['user'] = $this->session->userdata('user');
        $data['listImages'] = $this->user->getPhoto($data['user']->id, 0);
        $data['isMobile'] = $this->agent->is_mobile();
        $data['page'] = 'user/uploadphoto';
        $this->load->view('templates', $data);
    }

    function myPhoto(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Mine billeder');

        $data['user'] = $this->session->userdata('user');
        $data['listImages'] = $this->user->getPhoto($data['user']->id, 0);
        //$data['listProfilePictures'] = $this->user->getPhoto($data['user']->id, 2);
        $data['page'] = 'user/myphoto';
        $this->load->view('templates', $data);
    }

    function editphoto($imageId){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Rediger billede');

        $data['user'] = $this->session->userdata('user');
        $data['image'] = $this->user->getPhotoDetail($imageId);
        $data['isMobile'] = $this->agent->is_mobile();
        $data['page'] = 'user/editphoto';
        $this->load->view('templates', $data);
    }

    function editAvatar(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Rediger avatar');

        $user = $this->session->userdata('user');
        $data['isMobile'] = $this->agent->is_mobile();
        $data['listImages'] = $this->user->getPhoto($user->id);
        $data['user'] = $this->user->getUser($user->id);
        $data['page'] = 'user/editavatar';
        $this->load->view('templates', $data);
    }

    function deleteAvatar(){
        $user = $this->session->userdata('user');

        $currentAvatar = $this->user->getAvatar($user->id);
        if($currentAvatar != 'no-avatar1.png' && $currentAvatar != 'no-avatar2.png'){
            @unlink("./uploads/user/".$currentAvatar);
            @unlink("./uploads/thumb_user/".$currentAvatar);
            @unlink("./uploads/raw_thumb_user/".$currentAvatar);
        }

        $newAvatar = $this->user->getNewAvatar($user->id);
        if($newAvatar != ''){
            @unlink("./uploads/user/".$newAvatar);
            @unlink("./uploads/thumb_user/".$newAvatar);
            @unlink("./uploads/raw_thumb_user/".$newAvatar);
        }

        if($user->gender == 1){
            $noAvatarName = 'no-avatar1.png';
        } else {
            $noAvatarName = 'no-avatar2.png';
        }
        $this->user->updateAvatar($user->id, $noAvatarName);

        $this->updateUserSession($user->id);

        customRedirectWithMessage($_SERVER['HTTP_REFERER']);
    }

    public function blurAvatar(){
        $user = $this->session->userdata('user');
        $currentAvatar = $this->user->getAvatar($user->id);
        $imagePath = "./uploads/thumb_user/".$currentAvatar;

        $fileExt = pathinfo($imagePath,PATHINFO_EXTENSION);
        $blurs = 70;
        if($fileExt == 'png'){
            $image = imagecreatefrompng($imagePath);
            for ($i = 0; $i < $blurs; $i++) {
                imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
            }
            imagepng($image, "./uploads/thumb_user/".$currentAvatar);
        } else {
            $image = imagecreatefromjpeg($imagePath);
            for ($i = 0; $i < $blurs; $i++) {
                imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
            }
            imagejpeg($image, "./uploads/thumb_user/".$currentAvatar);
        }
        imagedestroy($image);

        customRedirectWithMessage($_SERVER['HTTP_REFERER']);
    }

    public function unblurAvatar(){
        $user = $this->session->userdata('user');
        $currentAvatar = $this->user->getAvatar($user->id);
        $imagePath = "./uploads/user/".$currentAvatar;
        list($imgWidth, $imgHeight) = getimagesize($imagePath);

        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = $imagePath;
        $config_resize['new_image'] = './uploads/thumb_user/'.$currentAvatar;
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
            redirect("errorhandler"); //If error, redirect to an error page
        }else {
            $config_crop['image_library'] = 'gd2';
            $config_crop['source_image'] = './uploads/thumb_user/' . $currentAvatar;
            $config_crop['new_image'] = './uploads/thumb_user/' . $currentAvatar;
            $config_crop['quality'] = "100%";
            $config_crop['maintain_ratio'] = FALSE;
            $config_crop['width'] = 500;
            $config_crop['height'] = 500;
            $config_crop['x_axis'] = '0';
            $config_crop['y_axis'] = '0';

            $this->image_lib->clear();
            $this->image_lib->initialize($config_crop);

            $this->image_lib->crop();
        }
        customRedirectWithMessage($_SERVER['HTTP_REFERER']);
    }

    public function saveAvatar(){
        $sendEmailToApprove = $this->input->post('sendEmailToApprove');
        if($sendEmailToApprove){
            $this->sendEmailAdminToApproveAvatar();
        }
        $imageData = $this->input->post('imageData');
        $blurIndex = $this->input->post('blurIndex');

        $user = $this->session->userdata('user');


        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        /*$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));*/
        $newAvatar = $this->user->getNewAvatar($user->id);
        if(!empty($newAvatar)){
            $avatar = $newAvatar;
        } else {
            $avatar = $this->user->getAvatar($user->id);
        }
        $thumb_user = './uploads/thumb_user/'.$avatar;
        if(file_put_contents($thumb_user, $image)){
            $this->user->updateBlurIndex($user->id, $blurIndex);
            $this->updateUserSession($user->id);
            customRedirectWithMessage(site_url('user/index'));
        }
    }

    public function saveEditedPhoto(){
        $imageData = $this->input->post('imageData');
        $blurIndex = $this->input->post('blurIndex');
        $imageName = $this->input->post('imageName');

        $user = $this->session->userdata('user');


        $imageData = str_replace('data:image/png;base64,', '', $imageData);
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
                redirect("errorhandler"); //If error, redirect to an error page
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

            }

            customRedirectWithMessage($_SERVER['HTTP_REFERER']);
        }
    }

    function sendEmailAdminToApproveAvatar(){
        $user = $this->session->userdata('user');
        $link = '<a href="'.base_url().'admin/en/mod_user/user?name='.$user->name.'">Link</a>';
        $content = 'Hej Admin<br /><br />
                        '.$user->name.' har uploadet en avatar, se venligst dette link for at tjekke det: '.$link.'<br /><br />
                        Med venlig hilsen<br/>
                        <a href="'.base_url().'">Habibidating.dk®</a>';
        $this->general_model->sendEmail(['approvepicture@habibidating.dk'], 'Habibidating.dk - '.$user->name.'har uploadet en avatar', $content);
        /*$this->session->set_flashdata('message', 'Billedet er sendt til validering og det blir gjordt indenfor 24 timer mvh kundeservice');*/
    }

    /** Message*/
    function messages($offset = 0)
    {
        //Checking dated
        $user = $this->session->userdata('user');
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Besked');

        $config['base_url'] = base_url() . '/user/messages/';
        $config['total_rows'] = $this->user->getNumUserSent($user->id);
        $config['per_page'] = $this->config->item('item_per_page');
        //$config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $list = $this->user->getUserSent($user->id, $config['per_page'], (int)$offset);
        $data['pagination'] = $this->pagination->create_links();

        $data['list'] = $list;
        $data['ignore'] = $this->user->getBlockedUserIds($user->id);

        $data['page'] = 'user/messages';
        $this->load->view('templates', $data);
    }



    function deleteMessage($profileId){
        $user = $this->session->userdata('user');
        $this->user->deleteMessage($user->id, $profileId);
        customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Din besked er slettet');
    }



    function favorites($offset = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Favoritter list');

        $data['user'] = $this->session->userdata('user');

        $ignore = $this->user->getBlockedUserIds($data['user']->id);

        $config['base_url'] = base_url() . '/user/favorites/';
        $config['total_rows'] = $this->user->getNumFavorite($data['user']->id, $ignore);
        $config['per_page'] = $this->config->item('item_per_page');
        //$config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $list = $this->user->getFavorites($data['user']->id, $config['per_page'], (int)$offset, $ignore);
        $data['pagination'] = $this->pagination->create_links();

        $data['list'] = $list;

        $data['isMobile'] = $this->agent->is_mobile();
        $data['page'] = 'user/favorites';
        $this->load->view('templates', $data);
    }

    public function deleteUser($friendId){
        $user = $this->session->userdata('user');
        $result = $this->user->removeUser($user->id, $friendId);
        if($result){
            redirect(site_url('/user/positiv'));
        } else {
            customRedirectWithMessage(site_url('user/positiv'), 'Kan ikke slette denne bruger');
        }
    }


    public function blockUser($profile_id){
        $user = $this->session->userdata('user');
        $this->user->addUserToBlockedList($user->id, $profile_id);
        customRedirectWithMessage(site_url('user/blockList'), 'Du har blokeret denne profil');
    }

    public function unblockUser($friendId){
        $user = $this->session->userdata('user');
        $result1 = $this->user->removeUserToBlockList($user->id, $friendId);
        if($result1){
            customRedirectWithMessage($_SERVER['HTTP_REFERER']);
        }
    }

    function blockList($offset = 0)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Blok liste');

        $data['user'] = $this->session->userdata('user');

        $config['base_url'] = base_url() . '/user/blockList/';
        $config['total_rows'] = count($this->user->getBlockedUserIds($data['user']->id));
        $config['per_page'] = $this->config->item('item_per_page');;
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $userList = $this->user->getBlockList($data['user']->id, $config['per_page'], (int)$offset);
        $data['pagination'] = $this->pagination->create_links();

        $data['list'] = $userList;

        $data['isMobile'] = $this->agent->is_mobile();
        $data['page'] = 'user/blocklist';
        $this->load->view('templates', $data);
    }

    function searching($offset = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Søgeresultat');

        if($this->input->post()){
            $this->_updateSearchDataFromForm();
        }

        $searchData = $this->session->userdata('searchData');

        $user = $this->session->userdata('user');

        /*$ignore = $this->user->getBlockedUserIds($user->id);
        if ($user) {
            $ignore[] = $user->id;
        }*/
        /** Search browsing*/

        /*$year = date('Y', time());
        $yearFrom       = $this->input->get('toAge')?$year - $this->input->get('toAge'):null;
        $yearTo         = $this->input->get('fromAge')?$year - $this->input->get('fromAge'):null;
        $land           = $this->input->get('land');
        $region         = $this->input->get('region');
        $gender         = $this->input->get('gender')?$this->input->get('gender'):(string)$user->find_gender;
        $relationship   = $this->input->get('relationship');
        $children       = $this->input->get('children');
        $ethnic         = $this->input->get('ethnic');
        $religion       = $this->input->get('religion');
        $training       = $this->input->get('training');
        $body           = $this->input->get('body');
        $smoking        = $this->input->get('smoking');

        $search = array();
        if ($yearFrom) {
            $search['yearFrom'] = $yearFrom;
        }
        if ($yearTo) {
            $search['yearTo'] = $yearTo;
        }
        if ($land) {
            $search['land'] = $land;
        }
        if ($region) {
            $search['region'] = $region;
        }
        if ($gender) {
            $search['gender'] = $gender;
        }
        if ($relationship) {
            $search['relationship'] = $relationship;
        }
        if ($children) {
            $search['children'] = $children;
        }
        if ($ethnic) {
            $search['ethnic'] = $ethnic;
        }
        if ($religion) {
            $search['religion'] = $religion;
        }
        if ($training) {
            $search['training'] = $training;
        }
        if ($body) {
            $search['body'] = $body;
        }
        if ($smoking) {
            $search['smoking'] = $smoking;
        }


        $config['base_url'] = base_url() . '/user/searching';
        $config['total_rows'] = $this->user->getNum($search, $ignore);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        //Get parameter for pagination
        if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
        $config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);

        $this->pagination->initialize($config);
        $list = $this->user->getBrowsing($config['per_page'], (int)$offset, $search, $ignore);
        $data['pagination'] = $this->pagination->create_links();

        $data['list'] = $list;
        $data['num'] = $config['total_rows'];*/
        $data['searchData'] = $searchData;
        $data['page'] = 'user/search';
        $this->load->view('templates', $data);
    }

    /** User*/
    function register(){
        //Check recaptcha
        $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'secret' => '6LfOWysUAAAAAGK3jSpOghyJD-x4FHStA_DE2cks',
            'response' => $recaptchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ));

        $resp = json_decode(curl_exec($ch));
        curl_close($ch);

        if ($resp->success == false) {
            customRedirectWithMessage('register', 'Ugyldig Google Recaptcha');
        }

        //
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        if ($this->input->post()) {

            $DB['name'] = $this->input->post('name');
            $DB['email'] = $this->input->post('email');
            $DB['password'] = md5($this->input->post('password'));
            $DB['year'] = $this->input->post('year');
            $DB['land'] = $this->input->post('land');
            $DB['region'] = $this->input->post('region');
            $DB['gender'] = $this->input->post('gender');
            $DB['find_gender'] = $this->input->post('find_gender');
            $DB['find_land'] = $this->input->post('find_land');
            $DB['find_region'] = $this->input->post('find_region');

            if($this->input->post('gender') == 1){
                $DB['avatar'] = 'no-avatar1.png';
            } else {
                $DB['avatar'] = 'no-avatar2.png';
            }

            $DB['type'] = 1;
            $DB['groups'] = 1; //1: register - 2: facebook - 3: google
            $DB['os'] = $this->agent->platform();
            $DB['ip'] = $this->input->ip_address();
            $mobile = $this->agent->mobile();
            if ($mobile) {
                $DB['device'] = 'Mobile';
            } else {
                $DB['device'] = 'Desktop';
            }
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;

            $id = $this->user->saveUser($DB);

            if ($id) {
                $this->session->set_userdata('name', $DB['name']);
                $this->session->set_userdata('email', $DB['email']);
                $this->session->set_userdata('password', $this->input->post('password'));
                $user = $this->user->getUser('', $DB['email'], $DB['password']);
                $this->session->set_userdata('user', $user);
                $this->session->set_userdata('isLoginSite', true);
                $this->_updateSearchDataAfterLogin();
                //Send email
                $sendEmailInfo['name'] = $DB['name'];
                $sendEmailInfo['email'] = $DB['email'];
                $sendEmailInfo['password'] = $this->input->post('password');
                $emailTo = array($DB['email']);
                sendEmail($emailTo,'registerFreeMember',$sendEmailInfo,'');

                redirect(site_url('user/start'));
            } else {
                customRedirectWithMessage('register', 'Fejl-system, skal du handling igen!');
            }
            /*$data['payment'] = false;
            header('Content-Type: application/json');
            echo json_encode($data);
            return;*/
        }
    }

    /** PAYMENT*/


    /** END PAYMENT*/
    function update(){
        $user = $this->session->userdata('user');
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Rediger profil - '.$user->name);


        if ($this->input->post()) {
            $currentPassword = md5($this->input->post('currentPassword', true));
            //Login user
            $correctUser = $this->user->getUser($user->id, null, $currentPassword);
            if(empty($correctUser)){
                $this->session->set_flashdata('message', "Adgangskoden er forkert");
                redirect(site_url('user/update'));
            }

            $DB['name']             = $this->input->post('name');
            $DB['email']            = $this->input->post('email');
            $DB['day']              = $this->input->post('day');
            $DB['month']            = $this->input->post('month');
            $DB['year']             = $this->input->post('year');
            $DB['birthday']         = $this->input->post('day') . '/' . $this->input->post('month') . '/' . $this->input->post('year');
            $DB['height']           = $this->input->post('height');
            $DB['weight']           = $this->input->post('weight');
            $DB['region']           = $this->input->post('region');
            $DB['land']             = $this->input->post('land');
            $DB['relationship']     = $this->input->post('relationship');
            $DB['children']         = $this->input->post('children');
            $DB['find_land']        = $this->input->post('find_land');
            $DB['find_region']      = $this->input->post('find_region');
            $DB['religion']         = $this->input->post('religion');
            $DB['training']         = $this->input->post('training');
            $DB['body']             = $this->input->post('body');
            $DB['smoking']          = $this->input->post('smoking');
            $DB['business']         = $this->input->post('business');
            $DB['job_type']         = $this->input->post('job_type');
            $DB['hair_color']       = $this->input->post('hair_color');
            $DB['eye_color']        = $this->input->post('eye_color');
            $DB['zodiac']           = $this->input->post('zodiac');
            $DB['slogan']           = $this->input->post('slogan');
            $DB['description']      = $this->input->post('description');
            $DB['chat']             = $this->input->post('chat');
            if ($this->input->post('password') && $this->input->post('repassword')) {
                if ($this->input->post('password') != $this->input->post('repassword')) {
                    $this->session->set_flashdata('message', "Genadgangskode er forkert");
                    redirect(site_url('user/update'));
                } else {
                    $DB['password'] = md5($this->input->post('password'));
                }
            }
            $status = $this->user->saveUser($DB, $user->id);
            if ($status) {
                $savedUser = $this->user->getUser($user->id);
                $this->session->set_userdata('user', $savedUser);
                /*$this->session->set_flashdata('message', "Opdater succesfuldt");*/
                redirect(site_url('user/index'));
            } else {
                /*$this->session->set_flashdata('message', "Fejl ved opdatering");*/
                redirect(site_url('user/update'));
            }
        }

        $data['user'] = $this->user->getUser($user->id);
        //$data['listProfilePictures'] = $this->user->getPhoto($user->id, 2);
        //$data['item'] = $this->user->getUser($user->id);
        $data['page'] = 'user/update';
        $this->load->view('templates', $data);
    }

    function changePassword(){
        $user = $this->session->userdata('user');
        if ($this->input->post('password') && $this->input->post('repassword')) {
            if ($this->input->post('password') != $this->input->post('repassword')) {
                $this->session->set_flashdata('message', "Genadgangskode er forkert");
                redirect(site_url('user/update'));
            } else {
                $DB['password'] = md5($this->input->post('password'));
            }
        }
        $this->user->saveUser($DB, $user->id);
        $savedUser = $this->user->getUser($user->id);
        $this->session->set_userdata('user', $savedUser);
        $this->session->set_flashdata('message', "Dit nye kodeord er ændret");
        redirect(site_url('user/update'));
    }

    /**
     *upgrade to gold member
     */
    function upgrade(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Opgrader konto');

        $data['page'] = 'user/upgrade';
        $this->load->view('templates', $data);
    }

    function forgotpass()
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);


        $data['page'] = 'user/forgotpass';
        $this->load->view('templates', $data);
    }

    /**
     * @author T.Trung
     */
    public function forgotPassHandler()
    {
        $data = array();
        $email = $this->input->post('email');
        //check validation
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_message('valid_email', 'Email feltet skal indeholde en gyldig email-adresse.');
        if ($this->form_validation->run() == false) {
            $data['status'] = false;
            $data['message'] = validation_errors();
            //customRedirectWithMessage(site_url('user/forgotpass'), validation_errors());
        }

        $user = $this->user->getUser('', $email);

        if (empty($user)) {
            $data['status'] = false;
            $data['message'] = 'Denne konto er ikke registreret, skal du kontrollere igen.';
            //customRedirectWithMessage(site_url('user/forgotpass'), 'Denne konto er ikke registreret, skal du kontrollere igen.');
        } else {
            if (!empty($user->facebook)) {
                //customRedirectWithMessage(site_url('user/forgotpass'), 'Denne konto er logget af Facebook, kan ikke ændre password på denne hjemmeside.');
            } else {
                $new_password = $this->randomPassword(12, 1, "lower_case,upper_case,numbers");
                $content = 'Kære ' . $user->name . '<br /><br />
                        Din nye adgangskode er: <b>'.$new_password[0].'</b><br /><br />
                        Har du spørgsmål kontakt info@habibidating.dk<br /><br />
                        Med venlig hilsen<br/>
                        <a href="'.base_url().'">Habibidating.dk®</a>';
                $sent = $this->general_model->sendEmail([$user->email], 'Habibidating.dk - Glemt adgangskode', $content);
                if($sent === true){
                    $data['password'] = md5($new_password[0]);
                    $this->user->saveUser($data, $user->id);
                    //customRedirectWithMessage(base_url(), 'En email er sendt til din email, vær venlig at tjekke det, tak.');
                    $data['status'] = true;
                    $data['message'] = 'En email er sendt til din email, vær venlig at tjekke det, tak.';
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
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

    function login(){
        $info = $this->input->post('info', true);
        $password = md5($this->input->post('password', true));
        //Login user
        $user = $this->user->getUser('', $info, $password);
        if ($user) {
            if($user->deleted != null){
                $data['status'] = false;
                $data['message'] = 'Denne konto er blevet slettet';
            } else {
                $data['status'] = true;
                $this->session->set_userdata('isLoginSite', true);
                $this->session->set_userdata('user', $user);
                $this->user->updateLogin($user->id, 1);
                $this->_updateSearchDataAfterLogin();
                //setcookie('cc_data', $user->id, time() + (86400 * 30), "/");
            }
        } else {
            $data['status'] = false;
            $data['message'] = 'E-mail / Brugernavn eller adgangskode er forkert, prøv igen!';
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function logout(){
        /** Login*/
        $user = $this->session->userdata('user');

        if($user){
            $Login = array('isLoginSite', 'user', 'email', 'password', 'lastVisitTime');
            $this->session->unset_userdata($Login);
            $this->user->updateLogin($user->id, 0);
        }
        //setcookie('cc_data', '', -time() + (86400 * 30), "/");

        redirect(site_url());
    }

    /** Action function*/



    function receivedBlinks($page = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Modtagne blinks');

        $data['user'] = $this->session->userdata('user');

        $ignore = $this->user->getBlockedUserIds($data['user']->id);

        $config['base_url'] = base_url() . '/user/receivedBlinks/';
        $config['total_rows'] = $this->user->getNumReceivedBlinks($data['user']->id, $ignore);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getReceivedBlinks($data['user']->id, $config['per_page'], (int)$page, $ignore);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/receivedblinks';
        $this->load->view('templates', $data);
    }

    /**
     * @param int $page
     * @return load view layout
     */
    function sentBlinks($page = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Sendt blinks');

        $data['user'] = $this->session->userdata('user');

        $ignore = $this->user->getBlockedUserIds($data['user']->id);

        $config['base_url'] = base_url() . '/user/receivedBlinks/';
        $config['total_rows'] = $this->user->getNumSentBlinks($data['user']->id, $ignore);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getSentBlinks($data['user']->id, $config['per_page'], (int)$page, $ignore);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/sentblinks';
        $this->load->view('templates', $data);
    }

    function visitMe($page = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Besøgte mig');

        $data['user'] = $this->session->userdata('user');

        $ignore = $this->user->getBlockedUserIds($data['user']->id);

        $config['base_url'] = base_url() . '/user/visitMe/';
        $config['total_rows'] = $this->user->getNumVisitMe($data['user']->id, $ignore);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getVisitMe($data['user']->id, $config['per_page'], (int)$page, $ignore);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/visitme';
        $this->load->view('templates', $data);
    }

    function visited($page = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Medlemmer jeg har besøgt');

        $data['user'] = $this->session->userdata('user');

        $ignore = $this->user->getBlockedUserIds($data['user']->id);

        $config['base_url'] = base_url() . '/user/visited/';
        $config['total_rows'] = $this->user->getNumVisited($data['user']->id, $ignore);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getVisited($data['user']->id, $config['per_page'], (int)$page, $ignore);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/visited';
        $this->load->view('templates', $data);
    }

    public function friendRequests(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Venneanmodninger');

        $user = $this->session->userdata('user');
        $ignore = $this->user->getBlockedUserIds($user->id);

        $receivedRequests = $this->user->getReceivedRequests($user->id, $ignore);
        $sentRequests = $this->user->getSentRequests($user->id, $ignore);
        $rejectedRequests = $this->user->getRejectedRequests($user->id, $ignore);

        $data['receivedRequests'] = $receivedRequests;
        $data['sentRequests'] = $sentRequests;
        $data['rejectedRequests'] = $rejectedRequests;

        $data['page'] = 'user/friendrequests';
        $this->load->view('templates', $data);
    }



    function friends($offset = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Venner');
        $keyword = $this->input->get('keyword', true);

        $data['user'] = $this->session->userdata('user');
        $ignore = $this->user->getBlockedUserIds($data['user']->id);

        $config['base_url'] = base_url() . '/user/friends/';
        $config['total_rows'] = $this->user->getNumFriends($data['user']->id, $ignore, $keyword);
        $config['per_page'] = $this->config->item('item_per_page');
        //$config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $list = $this->user->getFriends($data['user']->id, $config['per_page'], (int)$offset, $ignore, $keyword);
        $data['pagination'] = $this->pagination->create_links();

        $data['list'] = $list;
        $data['friendQuantity'] = $config['total_rows'];

        $data['page'] = 'user/friends';
        $this->load->view('templates', $data);
    }

    public function updateUserSession($userId){
        $newUser = $this->user->getUser($userId);
        $this->session->set_userdata('user', $newUser);
    }

    public function report(){
        $userId = $this->input->post('userId');
        $profileId = $this->input->post('profileId');

        $userName = $this->input->post('userName');
        $profileName = $this->input->post('profileName');
        $reason = $this->input->post('reason');

        $linkProfileName = '<a href="'.base_url().'admin/en/mod_user/user?name='.$profileName.'">'.$profileName.'</a>';

        $content = 'Hej Admin<br /><br />
                        '.$linkProfileName.' er rapporteret af '.$userName.'.<br />
                        Grund: '.$reason.'<br /><br />
                        <a href="'.base_url().'">Habibidating.dk®</a>';
        $sent = $this->general_model->sendEmail(['reportprofile@habibidating.dk'], 'Habibidating.dk - Bruger rapport', $content);
        if($sent){
            $this->user->saveReport($userId, $profileId, $reason);
        }
        customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Tak for anmeldesen vi undersøger den så hurtigt som muligt mvh kundeservice');
    }

    public function selectAvatarFromGallery(){
        $imageName = $this->input->post('imageName');
        $user = $this->session->userdata('user');
        /*$currentAvatar = $this->user->getAvatar($user->id);
        if($currentAvatar != 'no-avatar1.png' && $currentAvatar != 'no-avatar2.png'){
            @unlink("./uploads/user/".$currentAvatar);
            @unlink("./uploads/thumb_user/".$currentAvatar);
            @unlink("./uploads/raw_thumb_user/".$currentAvatar);
        }
        $this->user->updateAvatar($user->id, $imageName);*/

        $newAvatar = $this->user->getNewAvatar($user->id);
        if($newAvatar != ''){
            @unlink("./uploads/user/".$newAvatar);
            @unlink("./uploads/thumb_user/".$newAvatar);
            @unlink("./uploads/raw_thumb_user/".$newAvatar);
        }
        $this->user->updateAvatar($user->id, $imageName, 1);
        //Sending approve email
        $this->sendEmailAdminToApproveAvatar();

        $savedUser = $this->user->getUser($user->id);
        $this->session->set_userdata('user', $savedUser);

        //create thumb
        $config_resize['image_library'] = 'gd2';
        $config_resize['source_image'] = './uploads/raw_photo/'.$imageName;
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
            redirect("errorhandler"); //If error, redirect to an error page
        }else {
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
        }
        customRedirectWithMessage($_SERVER['HTTP_REFERER']);
    }

    private function _updateSearchDataAfterLogin(){
        $user = $this->session->userdata('user');
        $searchData = array();
        $searchData['gender'][] = $user->find_gender;
        $searchData['order'] = 'newest';
        $searchData['fromAge'] = 18;
        $searchData['toAge'] = 90;
        /*$searchData['fromHeight'] = 100;
        $searchData['toHeight'] = 230;
        $searchData['fromWeight'] = 40;
        $searchData['toWeight'] = 220;*/
        $searchData['land'][] = $user->find_land;
        $searchData['region'][] = $user->find_region;
        $this->session->set_userdata('searchData', $searchData);
    }

    private function _updateSearchDataFromForm(){
        $user = $this->session->userdata('user');
        $searchData = $this->input->post();
        $searchData['gender'][] = $user->find_gender;
        $searchData['order'] = 'newest';
        $this->session->set_userdata('searchData', $searchData);
    }

    public function testChat(){
        /*print_r($_SESSION);exit();*/
        $data['page'] = 'user/testchat';
        $this->load->view('templates', $data);
    }

    function testEmail()
    {
        var_dump($this->general_model->sendEmail(['trung@mywebcreations.dk'], 'Test subject '.date('d/m/Y H:i'), 'Test content '.date('d/m/Y H:i')));
        echo date('d/m/Y H:i');
        exit();
    }

    function setStandByStatus($status){
        $user = $this->session->userdata('user');
        if($status == 1){
            $currentPassword = md5($this->input->post('currentPassword', true));
            //Login user
            $correctUser = $this->user->getUser($user->id, null, $currentPassword);
            if(empty($correctUser)){
                $this->session->set_flashdata('message', "Adgangskoden er forkert");
                redirect(site_url('user/update'));
            }
        }

        $db['stand_by_payment'] = $status;
        $this->user->saveUser($db, $user->id);
        $this->updateUserSession($user->id);

        customRedirectWithMessage($_SERVER['HTTP_REFERER']);
    }

    function setDeactivation($status){
        $user = $this->session->userdata('user');
        if($status == 1){
            $currentPassword = md5($this->input->post('currentPassword', true));
            //Login user
            $correctUser = $this->user->getUser($user->id, null, $currentPassword);
            if(empty($correctUser)){
                $this->session->set_flashdata('message', "Adgangskoden er forkert");
                redirect(site_url('user/update'));
            }
        }

        $db['deactivation'] = $status;
        $this->user->saveUser($db, $user->id);
        $this->updateUserSession($user->id);

        customRedirectWithMessage($_SERVER['HTTP_REFERER']);
    }

    function deleteAccount(){
        $user = $this->session->userdata('user');
        $currentPassword = md5($this->input->post('currentPassword', true));
        //Login user
        $correctUser = $this->user->getUser($user->id, null, $currentPassword);
        if(empty($correctUser)){
            $this->session->set_flashdata('message', "Adgangskoden er forkert");
            redirect(site_url('user/update'));
        }

        $db['deleted'] = time();
        $this->user->saveUser($db, $user->id);

        redirect(site_url('/user/logout'));
    }

    function contact(){
        $DB['name'] = $this->input->post('name');
        $DB['phone'] = $this->input->post('phone');
        $DB['email'] = $this->input->post('email');
        $DB['message'] = $this->input->post('message');
        //$admin = $this->config->item('email');
        //$emailTo = array($admin);
        $emailTo = array('info@habibidating.dk');
        if(sendEmail($emailTo, 'contact', $DB, '')){
            $data['status'] = true;
            $data['message'] = 'Tak for din henvendelse. Jeg vender hurtigst muligt tilbage til dig.';
        } else {
            $data['status'] = false;
            $data['message'] = 'E-mailen sendes ikke';
        }
        //Save DB
        /*$DB['dt_create'] = date('Y-m-d H:i:s');
        $DB['bl_active'] = 1;
        $this->general_model->saveContact($DB);*/

        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function setNoAvatar(){
        $query = $this->db->query('SELECT id, gender FROM tb_user WHERE avatar = "no-avatar.jpg"');
        $users = $query->result();

        foreach ($users as $key => $user){
            $this->db->set('avatar', '"no-avatar'.$user->gender.'.png"', FALSE);
            $this->db->where('id', $user->id);
            $this->db->update('user');
        }
    }

    /*function newsletter(){
        $email = $this->input->post('email');
        $apiKey = $this->config->item('mailchimpApiKey');
        $listId = $this->config->item('listId');
        $memberId = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);

        //Checking
        $auth = base64_encode( 'user:'. $apiKey );

        $url = 'https://'.$dataCenter.'.api.mailchimp.com/3.0/lists/'.$listId.'/members/' . $memberId;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
            'Authorization: Basic '. $auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpCode == 200){
            $this->session->set_flashdata('error', 'Denne email findes i vores system.');
            redirect(site_url('newsletter'));
        } else {
            //Creating
            $data = [
                'email' => $email,
                'status' => 'subscribed'
            ];

            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/';

            $json = json_encode([
                'email_address' => $data['email'],
                'status' => $data['status']
            ]);

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($httpCode == 200) {
                $this->session->set_flashdata('message', 'Tak for tilmelding vores nyhedsbrev.');
                redirect(site_url('newsletter'));
            } else {
                $this->session->set_flashdata('error', 'En fejl ved at tilføje e-mail til Mailchimp.');
                redirect(site_url('newsletter'));
            }
        }
    }*/

    function newsletter(){
        $email = $this->input->post('email');
        $pubKey = $this->config->item('mailJetPublicKey');
        $secKey = $this->config->item('mailJetSecretKey');
        $contactListId = $this->config->item('contactListId');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3/REST/contact/'.urlencode($email));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_USERPWD, $pubKey.':'.$secKey);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        if($httpCode == 200){
            $this->session->set_flashdata('error', 'Denne email findes i vores system.');
        } else {
            $data = array("Action" => "addnoforce", "Email" => $email);
            $dataStr = json_encode($data);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.mailjet.com/v3/REST/contactslist/'.$contactListId.'/managecontact');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataStr);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $pubKey.':'.$secKey);

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($httpCode == 400){
                $this->session->set_flashdata('error', 'En fejl ved at tilføje e-mail til system.');
            } else {
                $this->session->set_flashdata('message', "Tak fordi du har tilmeldt dig vores nyhedsbrev.<br><br>Det er vi glade for, derfor vil vi  sende dig en mail når vi går i luften så du kan få dine 3 måneders gratis prøve og samtidig være med i lodtrækningen om gavekort til Magasin du Nord");
            }
            curl_close ($ch);
        }
        redirect(site_url('newsletter'));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */