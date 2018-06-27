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
    }

    protected function middleware(){
        return array('Checklogin|only:profile,friendRequests,myphoto,uploadPhoto,friends,sentBlinks,messages,receivedBlinks,favorites,update,addFavorite,removeFavorite,upgrade,blocked,searching,editAvatar,visitMe,start', 'Checkgold|only:visitme');
    }

    public function start(){
        $data = $ignore = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Start');
        $user = $this->session->userdata('user');

        $ignore = $this->user->getBlockedUserIds($user->id);
        $ignore[] = $user->id;

        $randomUsers = $this->user->getList(4, 0, null, $ignore, null, 'random');

        $newestUsers = $this->user->getList(10, 0, null, $ignore, null, 'newest');

        $popularUsers = $this->user->getList(10, 0, null, $ignore, null, 'popular');

        $data['randomUsers'] = $randomUsers;
        $data['newestUsers'] = $newestUsers;
        $data['popularUsers'] = $popularUsers;
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
        $data['user'] = $this->session->userdata('user');
        $data['images'] = $this->user->getPhoto($data['user']->id);

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

        $images = $this->user->getPhoto($id);
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
        $this->user->addMeta($this->_meta, $data, 'Habibi - Min foto');

        $data['user'] = $this->session->userdata('user');
        $data['listImages'] = $this->user->getPhoto($data['user']->id);
        //$data['listProfilePictures'] = $this->user->getPhoto($data['user']->id, 2);
        $data['page'] = 'user/uploadphoto';
        $this->load->view('templates', $data);
    }

    function myPhoto(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Min foto');

        $data['user'] = $this->session->userdata('user');
        $data['listImages'] = $this->user->getPhoto($data['user']->id);
        //$data['listProfilePictures'] = $this->user->getPhoto($data['user']->id, 2);
        $data['page'] = 'user/myphoto';
        $this->load->view('templates', $data);
    }

    public function deletePhoto($photoId){
        $this->db->select('image');
        $this->db->from('user_image');
        $this->db->where('id', $photoId);
        $query = $this->db->get();
        $image = $query->row();

        unlink("./uploads/photo/".$image->image);
        unlink("./uploads/thumb_photo/".$image->image);

        $this->db->where('id',$photoId)->delete('user_image');

        customRedirectWithMessage($_SERVER['HTTP_REFERER']);
    }

    function editAvatar(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Rediger avatar');

        $user = $this->session->userdata('user');
        $data['user'] = $this->user->getUser($user->id);
        $data['page'] = 'user/editavatar';
        $this->load->view('templates', $data);
    }

    function deleteAvatar(){
        $user = $this->session->userdata('user');

        $currentAvatar = $this->user->getAvatar($user->id);
        if($currentAvatar != 'no-avatar.jpg'){
            @unlink("./uploads/user/".$currentAvatar);
            @unlink("./uploads/thumb_user/".$currentAvatar);
            @unlink("./uploads/raw_thumb_user/".$currentAvatar);
        }
        $this->user->updateAvatar($user->id, 'no-avatar.jpg');

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
        $imageData = $this->input->post('imageData');
        $blurIndex = $this->input->post('blurIndex');

        $user = $this->session->userdata('user');
        $currentAvatar = $this->user->getAvatar($user->id);

        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        /*$image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));*/
        $thumb_user = './uploads/thumb_user/'.$currentAvatar;
        if(file_put_contents($thumb_user, $image)){
            $this->user->updateBlurIndex($user->id, $blurIndex);
            customRedirectWithMessage(site_url('user/index'));
        }
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
        $config['base_url'] = base_url() . '/user/favorites/';
        $config['total_rows'] = $this->user->getNumFavorite($data['user']->id);
        $config['per_page'] = $this->config->item('item_per_page');
        //$config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $list = $this->user->getFavorites($data['user']->id, $config['per_page'], (int)$offset);
        $data['pagination'] = $this->pagination->create_links();

        $data['list'] = $list;

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
        customRedirectWithMessage(site_url('user/blockList'), 'Denne person er tilføjet til bloklisten');
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

        $data['page'] = 'user/blocklist';
        $this->load->view('templates', $data);
    }

    function searching($offset = 0)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Søgeresultat');
        $user = $this->session->userdata('user');

        $ignore = $this->user->getBlockedUserIds($user->id);
        if ($user) {
            $ignore[] = $user->id;
        }
        /** Search browsing*/

        $year = date('Y', time());
        $yearFrom       = $this->input->get('toAge')?$year - $this->input->get('toAge'):null;
        $yearTo         = $this->input->get('fromAge')?$year - $this->input->get('fromAge'):null;
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
        $data['num'] = $config['total_rows'];

        $data['page'] = 'user/search';
        $this->load->view('templates', $data);
    }

    /** User*/
    function register(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        if ($this->input->post()) {

            $DB['name'] = $this->input->post('name');
            $DB['email'] = $this->input->post('email');
            $DB['password'] = md5($this->input->post('password'));
            $DB['year'] = $this->input->post('year');
            $DB['region'] = $this->input->post('region');
            $DB['gender'] = $this->input->post('gender');
            $DB['ethnic_origin'] = $this->input->post('ethnic_origin');
            $DB['find_gender'] = $this->input->post('find_gender');
            $DB['find_ethnicity'] = $this->input->post('find_ethnicity');

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
            $this->session->set_userdata('name', $DB['name']);
            $this->session->set_userdata('email', $DB['email']);
            $this->session->set_userdata('password', $this->input->post('password'));
            $id = $this->user->saveUser($DB);
            $user = $this->user->getUser('', $DB['email'], $DB['password']);
            $this->session->set_userdata('user', $user);
            $this->session->set_userdata('isLoginSite', true);
            if ($id) {
                //Send email
                $sendEmailInfo['name'] = $DB['name'];
                $sendEmailInfo['email'] = $DB['email'];
                $sendEmailInfo['password'] = $this->input->post('password');
                $emailTo = array($DB['email']);
                sendEmail($emailTo,'registerFreeMember',$sendEmailInfo,'');

                $data['status'] = true;
                $data['message'] = '';
            } else {
                $data['status'] = false;
                $data['message'] = 'Fejl-system, skal du handling igen!';
            }
            $data['payment'] = false;
            header('Content-Type: application/json');
            echo json_encode($data);
            return;
        }
    }

    /** PAYMENT*/
    function success()
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $payment = $this->session->userdata('payment');
        $userId = $this->session->userdata('userid');
        $name = $this->session->userdata('name');
        $email = $this->session->userdata('email');
        $password = $this->session->userdata('password');
        if ($payment) {
            //Update payment
            $DB['subscriptionid'] = $this->input->get('subscriptionid');
            $DB['orderid'] = $this->input->get('orderid');
            $DB['price'] = $this->config->item('priceuser');
            $DB['type'] = 2;
            $DB['bl_active'] = 1;
            $DB['paymenttime'] = time();
            $DB['expired_at'] = strtotime('+1 month',$DB['paymenttime']);

            //Add to log
            $this->addPaymentLog($userId);

            //Send email
            $sendEmailInfo['name']      = $name;
            $sendEmailInfo['email']     = $email;
            $sendEmailInfo['password']  = $password;
            $sendEmailInfo['orderId']   = $DB['orderid'];
            $sendEmailInfo['price']     = $DB['price'].' DKK';
            $sendEmailInfo['expired']   = date('d/m/Y', $DB['expired_at']);
            $emailTo = array($email);
            sendEmail($emailTo,'registerGoldMember',$sendEmailInfo,'');

        } else {
            $DB['bl_active'] = 1;
        }
        $this->user->saveUser($DB, $userId);


        $this->session->unset_userdata('payment');
        $data['page'] = 'user/success';
        $this->load->view('templates', $data);
    }

    function cancel()
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('payment');

        $data['page'] = 'user/cancel';
        $this->load->view('templates', $data);
    }

    function callback()
    {
        //Check callback and save


    }

    /** END PAYMENT*/
    function update(){
        $user = $this->session->userdata['user'];
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
            $DB['region']           = $this->input->post('region');
            $DB['land']             = $this->input->post('land');
            $DB['gender']           = $this->input->post('gender');
            $DB['relationship']     = $this->input->post('relationship');
            $DB['children']         = $this->input->post('children');
            $DB['ethnic_origin']    = $this->input->post('ethnic_origin');
            $DB['religion']         = $this->input->post('religion');
            $DB['training']         = $this->input->post('training');
            $DB['body']             = $this->input->post('body');
            $DB['smoking']          = $this->input->post('smoking');
            $DB['slogan']           = $this->input->post('slogan');
            $DB['description']      = $this->input->post('description');
            if ($this->input->post('password') && $this->input->post('repassword')) {
                if ($this->input->post('password') != $this->input->post('repassword')) {
                    $this->session->set_flashdata('message', "Genadgangskode er forkert");
                    redirect(site_url('user/update'));
                } else {
                    $DB['password'] = md5($this->input->post('password'));
                }
            }
            $id = $this->user->saveUser($DB, $user->id);
            if ($id) {
                $savedUser = $this->user->getUser($id);
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

    /**
     *upgrade to gold member
     */
    function upgrade(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['page'] = 'user/upgrade';
        $this->load->view('templates', $data);
    }

    public function upgradeSuccess(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        /*$payment = $this->session->userdata('payment');*/
        $user = $this->session->userdata('user');

        //Update payment
        $DB['subscriptionid'] = $this->input->get('subscriptionid');
        $DB['orderid'] = $this->input->get('orderid');
        $DB['price'] = $this->config->item('priceuser');
        $DB['type'] = 2;
        $DB['bl_active'] = 1;
        $DB['paymenttime'] = time();
        $DB['expired_at'] = strtotime('+1 month',$DB['paymenttime']);

        //Add to log
        $this->addPaymentLog($user->id);

        //Send email
        $sendEmailInfo['name']      = $user->name;
        $sendEmailInfo['email']     = $user->email;
        $sendEmailInfo['orderId']   = $DB['orderid'];
        $sendEmailInfo['price']     = $DB['price'].' DKK';
        $sendEmailInfo['expired']   = date('d/m/Y', $DB['expired_at']);
        $emailTo = array($user->email);
        sendEmail($emailTo,'upgradeGoldMember',$sendEmailInfo,'');

        $this->user->saveUser($DB, $user->id);
        /*$this->session->unset_userdata('userid');
        $this->session->unset_userdata('payment');*/
        $data['page'] = 'user/upgradeSuccess';
        $this->load->view('templates', $data);
    }

    public function upgradeCancel(){
        customRedirectWithMessage(site_url('user/index'), 'Din betaling mislykkedes');
    }

    public function upgradeCallback(){

    }

    public function addPaymentLog($userId){
        if($this->input->get('txnid')){
            $logDb['userId']    = $userId;
            $logDb['txnid']     = $this->input->get('txnid');
            $logDb['orderId']   = $this->input->get('orderid');
            $logDb['amount']    = $this->input->get('amount')/100;
            $logDb['currency']  = $this->input->get('currency');
            $logDb['date']      = $this->input->get('date');
            $logDb['time']      = $this->input->get('time');
            $logDb['hash']      = $this->input->get('hash');
            $logDb['txnfee']    = $this->input->get('txnfee');
            $logDb['cardno']    = $this->input->get('cardno');
            $id = $this->user->addLog($logDb);
            if($id == false){
                customRedirectWithMessage(site_url('user/index'), 'Fejl ved lagring af log');
            }
        } else {
            customRedirectWithMessage(site_url('user/index'), 'Kan ikke finde betalingsoplysninger');
        }
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
                        Har du spørgsmål kontakt info@zeduuce.com<br /><br />
                        Med venlig hilsen<br/>
                        <a href="'.base_url().'">Zeduuce.com®</a>';
                $sent = $this->general_model->sendEmail([$user->email], 'Zeduuce.com - Glemt adgangskode', $content);
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
            $data['status'] = true;
            /*$data['b2b'] = false;
            $user->b2b = false;*/
            $this->session->set_userdata('isLoginSite', true);
            $this->session->set_userdata('user', $user);
            $this->user->updateLogin($user->id, false);

            //setcookie('cc_data', $user->id, time() + (86400 * 30), "/");
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function autoLogin()
    {
        $email = $this->session->userdata('email');
        $password = $this->session->userdata('password');
        if ($email && $password) {
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('password');
            $b2b = $this->user->getB2b('', $email, $password);
            if ($b2b) {
                $b2b->b2b = true;
                $this->session->set_userdata('isLoginSite', true);
                $this->session->set_userdata('user', $b2b);
                $this->user->updateLogin($b2b->id, true);
                redirect(site_url('user/b2b'));
                return;
            }
            //Login user
            $user = $this->user->getUser('', $email, $password);
            if ($user) {
                $data['status'] = true;
                $user->b2b = false;
                $this->session->set_userdata('isLoginSite', true);
                $this->session->set_userdata('user', $user);
                $this->user->updateLogin($user->id, false);
                redirect(site_url('user/index'));
                return;
            } else {
                redirect(site_url(''));
                return;
            }
        } else {
            redirect(site_url(''));
            return;
        }
    }



    function logout(){
        /** Login*/
        $curMethod = $this->router->fetch_method();
        $Login = array('isLoginSite', 'user', 'email', 'password', 'lastVisitTime');
        $this->session->unset_userdata($Login);

        //setcookie('cc_data', '', -time() + (86400 * 30), "/");

        redirect(site_url());
    }

    /** Action function*/



    function receivedBlinks($page = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Modtagne blinks');

        $data['user'] = $this->session->userdata('user');
        $config['base_url'] = base_url() . '/user/receivedBlinks/';
        $config['total_rows'] = $this->user->getNumReceivedBlinks($data['user']->id);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getReceivedBlinks($data['user']->id, $config['per_page'], (int)$page);
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
        $config['base_url'] = base_url() . '/user/receivedBlinks/';
        $config['total_rows'] = $this->user->getNumSentBlinks($data['user']->id);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getSentBlinks($data['user']->id, $config['per_page'], (int)$page);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/sentblinks';
        $this->load->view('templates', $data);
    }

    function visitMe($page = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Besøgte mig');

        $data['user'] = $this->session->userdata('user');
        $config['base_url'] = base_url() . '/user/visitMe/';
        $config['total_rows'] = $this->user->getNumVisitMe($data['user']->id);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getVisitMe($data['user']->id, $config['per_page'], (int)$page);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/visitme';
        $this->load->view('templates', $data);
    }

    function visited($page = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Medlemmer jeg har besøgt');

        $data['user'] = $this->session->userdata('user');
        $config['base_url'] = base_url() . '/user/visited/';
        $config['total_rows'] = $this->user->getNumVisited($data['user']->id);
        $config['per_page'] = $this->config->item('item_per_page');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['list'] = $this->user->getVisited($data['user']->id, $config['per_page'], (int)$page);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/visited';
        $this->load->view('templates', $data);
    }

    public function requestAddFriend($profile_id){
        $user = $this->session->userdata('user');

        if ($user && $profile_id) {
            $DB['user_from'] = $user->id;
            $DB['user_to'] = $profile_id;
            $DB['status'] = 0;
            $DB['dt_create'] = time();
            $id = $this->user->addRequestAddFriend($DB);
            if($id){
                customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Din anmodning er sendt');
            } else {
                customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Kan ikke gemme din anmodning');
            }
        } else {
            customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Mangler dit id');
        }
    }

    public function cancelAddFriend($profile_id){
        $user = $this->session->userdata('user');

        if ($user && $profile_id) {
            $this->user->cancelRequestAddFriend($user->id, $profile_id);
            customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Din anmodning er annulleret');
        } else {
            customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Mangler dit id');
        }
    }

    public function unFriend($profileId){
        $user = $this->session->userdata('user');

        if ($user && $profileId) {
            $this->user->cancelRequestAddFriend($user->id, $profileId);
            customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Denne person er fjernet til din venneliste');
        } else {
            customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Mangler dit id');
        }
    }

    function removeFavorite($profileId){
        $user = $this->session->userdata('user');
        if ($user && $profileId) {
            $id = $this->user->removeFavorite($user->id, $profileId);
            if ($id) {
                customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Denne person er blevet fjernet til din favoritliste');
            } else {
                customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Kan ikke fjerne');
            }
        } else {
            customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Manglende id');
        }
    }

    public function friendRequests(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Venneanmodninger');

        $user = $this->session->userdata('user');
        $receivedRequests = $this->user->getReceivedRequests($user->id);
        $sentRequests = $this->user->getSentRequests($user->id);

        $data['receivedRequests'] = $receivedRequests;
        $data['sentRequests'] = $sentRequests;

        $data['page'] = 'user/friendrequests';
        $this->load->view('templates', $data);
    }

    public function acceptAddFriend($profileId){
        $user = $this->session->userdata('user');
        $this->user->updateFriendRequest($user->id, $profileId, 1);
        $this->user->insertFriendList($user->id, $profileId);
        customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Den person er tilføjet til vennelisten');
    }

    public function rejectAddFriend($profileId){
        $user = $this->session->userdata('user');
        $this->user->updateFriendRequest($user->id, $profileId, 2);
        customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Den pågældende afvises til vennelisten');
    }

    function friends($offset = 0){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Venner');

        $data['user'] = $this->session->userdata('user');
        $config['base_url'] = base_url() . '/user/friends/';
        $config['total_rows'] = $this->user->getNumFriends($data['user']->id);
        $config['per_page'] = $this->config->item('item_per_page');
        //$config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $list = $this->user->getFriends($data['user']->id, $config['per_page'], (int)$offset);
        $data['pagination'] = $this->pagination->create_links();

        $data['list'] = $list;

        $data['page'] = 'user/friends';
        $this->load->view('templates', $data);
    }

    public function updateUserSession($userId){
        $newUser = $this->user->getUser($userId);
        $this->session->set_userdata('user', $newUser);
    }

    public function testChat(){
        /*print_r($_SESSION);exit();*/
        $data['page'] = 'user/testchat';
        $this->load->view('templates', $data);
    }

    function testEmail()
    {
        var_dump($this->general_model->sendEmail(['trung@mywebcreations.dk'], 'Test subject '.date('d/m/Y H:i'), 'Test content '.date('d/m/Y H:i')));
        exit();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */