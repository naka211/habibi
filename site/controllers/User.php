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
        return array('Checklogin|only:profile,b2b,myphoto,uploadPhoto,mydeal,mymessages,messages,deleteMessage,myinvitationer,deleteinvitationer,myinvitationerjoin,myinvitationerapproved,favorites,positiv,update,addFavorite,removeFavorite,sendKiss,removeKiss,getUserJoin,mycontactperson,sentkisses,receivedkisses,shoutouts,deleteShoutout,createShoutout,shoutoutSuccess,shoutoutCancel,upgrade,sentInvitation,approvedInvitation,deleteUserFromPostiveList,blocked', 'Checkgold|only:shoutouts,deleteShoutout,createShoutout,shoutoutSuccess,shoutoutCancel,saveShoutout,myinvitationerapproved,myinvitationerjoin');
    }

    function index(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        if (!checkLogin()) {
            redirect(site_url('home/index'));
        }
        /** Clear session search USER */
        /*$SearchUser = array('year_from' => '', 'year_to' => '', 'height_from' => '', 'height_to' => ''
        , 'gender' => '', 'relationship' => '', 'children' => '', 'ethnic_origin' => ''
        , 'religion' => '', 'training' => '', 'body' => '');
        $this->session->unset_userdata($SearchUser);*/

        $data['user'] = $this->session->userdata('user');
        $data['images'] = $this->user->getPhoto($data['user']->id);
        //$data['item'] = $this->user->getUser($data['user']->id);
        //$data['tilbud'] = $this->user->getMyTilbud($data['user']->id);
        //Change status shoutouts if they are more than 72 hours
        //$this->user->checkShoutoutsStatus($data['user']->id);
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

        //Adding positive notification
        /*if($this->user->countSeeTimes($id, $data['user']->id) == 3){
            $this->user->addNotification($id);
            $this->user->addStatus($data['user']->id, $id, 'SeeMore3Times');
            //Check to add to dated
            $this->checkToAddDated($data['user']->id, $id);
        }*/
        //Add action to log
        $this->user->addToVisiting($data['user']->id, $id);

        $images = $this->user->getPhoto($id);
        if ($images) {
            /*$data['avatar'] = $photo[0]->image;*/
            $data['images'] = $images;
        } else {
            $data['images'] = "";
        }

        /*$data['favorite'] = $this->user->checkFavorite($data['user']->id, $id);*/
        $data['status'] = $this->user->checkStatus($data['user']->id, $id);
        if(isGoldMember()){
            $data['messages'] = $this->user->getMessages($data['user']->id, $id, 10, 0);
            $data['numMessages'] = $this->user->getNumMessages($data['user']->id, $id);
        }

        $data['page'] = 'user/profile';
        $this->load->view('templates', $data);
    }

    function b2b($page = 0)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata('user');
        $data['deals'] = $this->user->getQuantityB2BDeals($data['user']->id);

        $config['base_url'] = base_url() . $this->language . '/user/b2b/';
        $config['total_rows'] = $this->user->getQuantityB2BDeals($data['user']->id);
        $config['per_page'] = $this->config->item('numberpage');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $data['deals'] = $this->user->getB2BDeals($data['user']->id, $config['per_page'], (int)$page);
        $data['pagination'] = $this->pagination->create_links();

        $data['page'] = 'user/b2b';
        $this->load->view('templates', $data);
    }

    /** Photo*/
    function myphoto()
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata('user');
        $data['listImages'] = $this->user->getPhoto($data['user']->id, 1);
        //$data['listProfilePictures'] = $this->user->getPhoto($data['user']->id, 2);
        $data['page'] = 'user/myphoto';
        $this->load->view('templates', $data);
    }

    function uploadPhoto()
    {
        $type = $this->input->post('type');
        if($type == 1){
            $upload_path = "./uploads/photo/";
            $imageFolder = "photo";
        } else if($type == 2){
            $upload_path = "./uploads/user/";
            $imageFolder = "user";
        }
        $user = $this->session->userdata('user');
        //$config['upload_path'] = $this->config->item('root') . "uploads/photo/";
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = $this->config->item('maxupload');
        $config['encrypt_name'] = TRUE;  //rename to random string image
        $this->load->library('upload', $config);
        if (isset($_FILES['myImage']['name'])) {
            $data_img = $this->upload->do_multi_upload('myImage');
            if ($data_img) {
                $data_img = $data_img;
            } else {
                $data_img[] = NULL;
            }
        } else {
            $data_img[] = NULL;
        }
        //Save image to DB
        $list = array();
        $DB['userID'] = $user->id;
        $DB['dt_create'] = date('Y-m-d H:i:s');
        $DB['bl_active'] = 1;
        $DB['type'] = $type;
        if ($data_img) {
            $i = 0;
            foreach ($data_img as $row) {
                $DB['image'] = $row['file_name'];
                $id = $this->user->savePhoto($DB);
                $list[$i]['image'] = $row['file_name'];
                $list[$i]['id'] = $id;
                $i++;
            }
        }
        $data['imageFolder'] = $imageFolder;
        $data['list'] = $list;
        $this->load->view('ajax/myphoto', $data);
        /**
         * $images_arr = array();
         * foreach($_FILES['myImage']['name'] as $key=>$val){
         * $image_name = $_FILES['myImage']['name'][$key];
         * $tmp_name    = $_FILES['myImage']['tmp_name'][$key];
         * $size        = $_FILES['myImage']['size'][$key];
         * $type        = $_FILES['myImage']['type'][$key];
         * $error        = $_FILES['myImage']['error'][$key];
         * //display images without stored
         * $extra_info = getimagesize($_FILES['myImage']['tmp_name'][$key]);
         * $images_arr[] = "data:" . $extra_info["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['myImage']['tmp_name'][$key]));
         * }
         * if($images_arr){
         * $i = 0;
         * foreach($images_arr as $image_src){ ?>
         * <li id="show_images_<?php echo $i;?>" class="portfolio isotope-item">
         * <div style="width: 150px !important; height: 150px !important; overflow: hidden;">
         * <a class="portfolio_img" href="javascript:void(0)">
         * <img src="<?php echo $image_src;?>" width="100%" height="100%" alt="" class="img-responsive"/>
         * </a>
         * </div>
         * <a href="javascript:void(0)" onclick="deleteImages('show_images_<?php echo $i;?>');"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
         * </li>
         * <?php $i++; }}
         */
    }

    function mydeal()
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata('user');
        $data['tilbud'] = $this->user->getMyTilbud($data['user']->id);
        $data['page'] = 'user/mydeal';
        $this->load->view('templates', $data);
    }

    /** Message*/
    function mymessages()
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata('user');
        $message = $this->user->getListMessage($data['user']->id);
        $list = "";
        if ($message) {
            $i = 0;
            foreach ($message as $row) {
                $userSend = $this->user->getUser($row->user_from);
                if ($userSend) {
                    $list[$i] = $userSend;
                    $list[$i]->notSeen = $this->user->getNotSeen($data['user']->id, $row->user_from);
                    $latestMessage = $this->user->getLatestMessage($data['user']->id, $row->user_from);
                    $list[$i]->message = $latestMessage->message;
                    $list[$i]->dt_create = $latestMessage->dt_create;
                    $i++;
                }
            }
        }
        $data['list'] = $list;
        $data['page'] = 'user/mymessages';
        $this->load->view('templates', $data);
    }

    function messages($id)
    {
        //Checking dated
        $user = $this->session->userdata('user');
        if(isDated($user->id, $id) === false){
            $this->session->set_flashdata('message', 'Du skal dateret med denne person for at bruge denne funktion !!');
            redirect(site_url('/user/index'));
        }

        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $user;
        $data['item'] = $this->user->getUser($id);
        $data['messages'] = $this->user->getMessages($data['user']->id, $id);
        $this->user->clearNotSeen($data['user']->id, $id);
        $data['page'] = 'user/messages';
        $this->load->view('templates', $data);
    }



    function deleteMessage($userID)
    {
        $user = $this->session->userdata('user');
        $this->user->deleteMessage_FT($user->id, $userID);
        $this->user->deleteMessage_TF($user->id, $userID);
        redirect(site_url('user/mymessages'));
    }



    function favorites($page = 0)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Favoritter list');


        $data['user'] = $this->session->userdata('user');
        $config['base_url'] = base_url() . '/user/favorites/';
        $config['total_rows'] = $this->user->getNumFavorite($data['user']->id);
        $config['per_page'] = 8;
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $list = $this->user->getFavorites($data['user']->id, $config['per_page'], (int)$page);
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

    /**
     * @param $friendId
     * @param $from 1: positive list, 2: profile
     */
    public function blockUser($profile_id){
        $user = $this->session->userdata('user');
        $this->user->addUserToBlockedList($user->id, $profile_id);
        customRedirectWithMessage(site_url('home/index'), 'Denne person er tilføjet til bloklisten');
        //disable user in positive list
        /*if($from == 1){
            $result2 = $this->user->blockUser($user->id, $friendId);
        } else {
            $result2 = true;
        }*/

        /*if($result1 && $result2){
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            customRedirectWithMessage(site_url('user/positiv'), 'Kan ikke blokere denne bruger');
        }*/
    }

    public function unblockUser($friendId){
        $user = $this->session->userdata('user');
        $result1 = $this->user->removeUserToBlockedList($user->id, $friendId);
        //enable the user in positive list
        $result2 = $this->user->unblockUser($user->id, $friendId);
        if($result1 && $result2){
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            customRedirectWithMessage(site_url('user/positiv'), 'Kan ikke fjerne blokeringen denne bruger');
        }
    }

    function blocked($page = 0)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        $data['user'] = $this->session->userdata('user');

        $config['base_url'] = base_url() . $this->language . '/user/blocked/';
        $config['total_rows'] = count($this->user->getBlockedUserIds($data['user']->id));
        //$config['per_page'] = $this->config->item('numberpage');
        $config['per_page'] = 5;
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $userList = $this->user->getBlockedList($config['per_page'], (int)$page, $data['user']->id);
        $data['pagination'] = $this->pagination->create_links();

        $data['userList'] = $userList;

        $data['page'] = 'user/blocked';
        $this->load->view('templates', $data);
    }

    function searching($page = 0, $invita = NULL)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        if ($invita) {
            $this->session->set_userdata('invita', $invita);
        }
        $user = $this->session->userdata('user');
        if ($user) {
            $ignore[] = $user->id;
        } else {
            $ignore = "";
        }
        /** Search browsing*/
        if ($this->input->post()) {
            $year = date('Y', time());
            $year_from = $year - $this->input->post('year_to');
            $year_to = $year - $this->input->post('year_from');
            $height_from = $this->input->post('height_from');
            $height_to = $this->input->post('height_to');
            $gender = $this->input->post('gender');
            //Array
            $relationship = $this->input->post('relationship');
            $children = $this->input->post('children');
            $ethnic_origin = $this->input->post('ethnic_origin');
            $religion = $this->input->post('religion');
            $training = $this->input->post('training');
            $body = $this->input->post('body');
            $smoking = $this->input->post('smoking');
            if ($year_from) {
                $search_1 = array('year_from' => $year_from);
            } else {
                $search_1 = array();
            }
            if ($year_to) {
                $search_2 = array('year_to' => $year_to);
            } else {
                $search_2 = array();
            }
            if ($height_from) {
                $search_3 = array('height_from' => $height_from);
            } else {
                $search_3 = array();
            }
            if ($height_to) {
                $search_4 = array('height_to' => $height_to);
            } else {
                $search_4 = array();
            }
            if ($gender) {
                $search_5 = array('gender' => $gender);
            } else {
                $search_5 = array();
            }
            if ($relationship) {
                $search_6 = array('relationship' => $relationship);
            } else {
                $search_6 = array();
            }
            if ($children) {
                $search_7 = array('children' => $children);
            } else {
                $search_7 = array();
            }
            if ($ethnic_origin) {
                $search_8 = array('ethnic_origin' => $ethnic_origin);
            } else {
                $search_8 = array();
            }
            if ($religion) {
                $search_9 = array('religion' => $religion);
            } else {
                $search_9 = array();
            }
            if ($training) {
                $search_10 = array('training' => $training);
            } else {
                $search_10 = array();
            }
            if ($body) {
                $search_11 = array('body' => $body);
            } else {
                $search_11 = array();
            }
            if ($smoking) {
                $search_12 = array('smoking' => $smoking);
            } else {
                $search_12 = array();
            }

            $search = array_merge($search_1, $search_2, $search_3, $search_4, $search_5, $search_6, $search_7, $search_8, $search_9, $search_10, $search_11, $search_12);
            $this->session->set_userdata($search);
        } else {
            $search['year_from'] = $this->session->userdata('year_from');
            $search['year_to'] = $this->session->userdata('year_to');
            $search['height_from'] = $this->session->userdata('height_from');
            $search['height_to'] = $this->session->userdata('height_to');
            $search['gender'] = $this->session->userdata('gender');
            $search['relationship'] = $this->session->userdata('relationship');
            $search['children'] = $this->session->userdata('children');
            $search['ethnic_origin'] = $this->session->userdata('ethnic_origin');
            $search['religion'] = $this->session->userdata('religion');
            $search['training'] = $this->session->userdata('training');
            $search['body'] = $this->session->userdata('body');
            $search['smoking'] = $this->session->userdata('smoking');
        }
        if (isset($search['year_from'])) {
            $data['year_from'] = date('Y', time()) - $search['year_to'];
        } else {
            $data['year_from'] = "";
        }
        if (isset($search['year_to'])) {
            $data['year_to'] = date('Y', time()) - $search['year_from'];
        } else {
            $data['year_to'] = "";
        }
        if (isset($search['height_from'])) {
            $data['height_from'] = $search['height_from'];
        } else {
            $data['height_from'] = "";
        }
        if (isset($search['height_to'])) {
            $data['height_to'] = $search['height_to'];
        } else {
            $data['height_to'] = "";
        }
        if (isset($search['gender'])) {
            $data['gender'] = $search['gender'];
        } else {
            $data['gender'] = "";
        }
        if (isset($search['relationship'])) {
            $data['relationship'] = $search['relationship'];
        } else {
            $data['relationship'] = "";
        }
        if (isset($search['children'])) {
            $data['children'] = $search['children'];
        } else {
            $data['children'] = "";
        }
        if (isset($search['ethnic_origin'])) {
            $data['ethnic_origin'] = $search['ethnic_origin'];
        } else {
            $data['ethnic_origin'] = "";
        }
        if (isset($search['religion'])) {
            $data['religion'] = $search['religion'];
        } else {
            $data['religion'] = "";
        }
        if (isset($search['training'])) {
            $data['training'] = $search['training'];
        } else {
            $data['training'] = "";
        }
        if (isset($search['body'])) {
            $data['body'] = $search['body'];
        } else {
            $data['body'] = "";
        }
        if (isset($search['smoking'])) {
            $data['smoking'] = $search['smoking'];
        } else {
            $data['smoking'] = "";
        }

        $config['base_url'] = base_url() . $this->language . '/user/browsing/';
        $config['total_rows'] = $this->user->getNum($search, $ignore);
        if(!empty($this->session->userdata('perPage'))){
            $data['perPage'] = $config['per_page'] = $this->session->userdata('perPage');
        } else {
            $data['perPage'] = $config['per_page'] = $this->config->item('numberpage');
        }
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $listUsers = $this->user->getBrowsing($config['per_page'], (int)$page, $search, $ignore);
        $data['pagination'] = $this->pagination->create_links();
        if ($listUsers) {
            $i = 0;
            foreach ($listUsers as $row) {
                $users[$i]['id'] = $row->id;
                $users[$i]['name'] = $row->name;
                $users[$i]['birthday'] = $row->birthday;
                $users[$i]['code'] = $row->code;
                $users[$i]['facebook'] = $row->facebook;
                $users[$i]['avatar'] = $row->avatar;
                /*if ($row->facebook && $row->avatar) {
                    $users[$i]['avatar'] = $row->avatar;
                } else {
                    $photo = $this->user->getPhoto($row->id);
                    if ($photo) {
                        $users[$i]['avatar'] = $photo[0]->image;
                    } else {
                        $users[$i]['avatar'] = "";
                    }
                }*/
                $i++;
            }
        } else {
            $users = "";
        }
        $data['list'] = $users;
        $favorite = array();
        if ($data['list'] && $user) {
            foreach ($data['list'] as $row) {
                $check = $this->user->checkFavorite($user->id, $row['id']);
                if ($check) {
                    $favorite[] = array(
                        'id' => $row['id'],
                    );
                } else {
                    $favorite[] = array(
                        'id' => 0,
                    );
                }

            }
        }

        $data['favorite'] = $favorite;
        $data['invita'] = $this->session->userdata('invita');
        $data['user'] = $user;
        $data['num'] = $config['total_rows'];
        $data['page'] = 'user/browsing';
        $this->load->view('templates', $data);
    }

    /** User*/
    function register(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        if ($this->input->post()) {
            /*$user = $this->user->getUser(NULL, $this->input->post('email'), NULL, NULL, NULL, 1);
            if ($user) {
                $data['status'] = false;
                $data['message'] = 'E-mail er allerede registeret!';
                header('Content-Type: application/json');
                echo json_encode($data);
                return;
            }*/
            $DB['name'] = $this->input->post('name');
            $DB['email'] = $this->input->post('email');
            $DB['password'] = md5($this->input->post('password'));
            /*$DB['code'] = $this->input->post('code');
            $DB['payment'] = $this->input->post('payment');
            $DB['day'] = $this->input->post('day');
            $DB['month'] = $this->input->post('month');*/
            $DB['year'] = $this->input->post('year');
            //$DB['birthday'] = $this->input->post('day') . '/' . $this->input->post('month') . '/' . $this->input->post('year');
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
            /*if ($DB['payment'] == 1 && $id) {
                $this->session->set_userdata('payment', true);
                $this->session->set_userdata('userId', $id);
                $data['status'] = true;
                $data['payment'] = true;
                $data['message'] = '';
                header('Content-Type: application/json');
                echo json_encode($data);
                return;
            }*/
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
        /*$data['page'] = 'user/register';
        $this->load->view('templates', $data);*/
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
            //Handle profile picture
            /*if(isset($_FILES['newAvatar']['name'])&&$_FILES['newAvatar']['name']!=""){
                $config['upload_path'] = $this->config->item('root')."uploads/user/";
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']	= $this->config->item('maxupload');
                $config['encrypt_name']	= TRUE;  //rename to random string image
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('newAvatar')){
                    $data_img = $this->upload->data();
                }else{
                    $this->session->set_flashdata('error', $this->upload->error_msg);
                    redirect(site_url('/user/update'));
                }
            }else {
                if($this->input->post('avatar')){
                    $data_img['file_name'] = $this->input->post('avatar');
                } else {
                    $data_img['file_name'] = '';
                }
            }

            //Delete profile picture
            if($this->input->post('deleteProfilePicture')){
                unlink("uploads/user/".$this->input->post('avatar'));
                $data_img['file_name'] = '';
            }*/

            /*$DB['avatar'] = $this->input->post('avatar');*/

            $DB['name']             = $this->input->post('name');
            $DB['day']              = $this->input->post('day');
            $DB['month']            = $this->input->post('month');
            $DB['year']             = $this->input->post('year');
            $DB['birthday']         = $this->input->post('day') . '/' . $this->input->post('month') . '/' . $this->input->post('year');
            $DB['code']             = $this->input->post('code');
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
                $this->session->set_flashdata('message', "Opdater succesfuldt");
                redirect(site_url('user/index'));
            } else {
                $this->session->set_flashdata('message', "Fejl ved opdatering");
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

        $payment = $this->session->userdata('payment');
        $user = $this->session->userdata('user');
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
            $this->addPaymentLog($user->id);

            //Send email
            $sendEmailInfo['name']      = $user->name;
            $sendEmailInfo['email']     = $user->email;
            $sendEmailInfo['orderId']   = $DB['orderid'];
            $sendEmailInfo['price']     = $DB['price'].' DKK';
            $sendEmailInfo['expired']   = date('d/m/Y', $DB['expired_at']);
            $emailTo = array($user->email);
            sendEmail($emailTo,'upgradeGoldMember',$sendEmailInfo,'');
        } else {
            $DB['bl_active'] = 1;
        }
        $this->user->saveUser($DB, $user->id);
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('payment');
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
        $email = $this->input->post('email', true);
        $password = md5($this->input->post('password', true));
        //Login b2b
        /*$b2b = $this->user->getB2b('', $email, $password);
        if ($b2b) {
            $b2b->b2b = true;
            $this->session->set_userdata('isLoginSite', true);
            $this->session->set_userdata('user', $b2b);
            $this->user->updateLogin($b2b->id, true);
            $data['status'] = true;
            $data['b2b'] = true;
            header('Content-Type: application/json');
            echo json_encode($data);
            return;
        }*/
        //Login user
        $user = $this->user->getUser('', $email, $password);
        if ($user) {
            $data['status'] = true;
            /*$data['b2b'] = false;
            $user->b2b = false;*/
            $this->session->set_userdata('isLoginSite', true);
            $this->session->set_userdata('user', $user);
            $this->user->updateLogin($user->id, false);

            setcookie('cc_data', $user->id, time() + (86400 * 30), "/");
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
                redirect(site_url('home/index'));
                return;
            }
        } else {
            redirect(site_url('home/index'));
            return;
        }
    }

    function loginFB()
    {
        $post = $this->input->post('response', true);
        if ($post) {
            $DB['name'] = $post['name'];
            $DB['email'] = $post['email'];
            $DB['facebook'] = $post['id'];
            $DB['os'] = $this->agent->platform();
            $DB['ip'] = $this->input->ip_address();
            $mobile = $this->agent->mobile();
            if ($mobile) {
                $DB['device'] = 'Mobile';
            } else {
                $DB['device'] = 'Desktop';
            }
            if ($post['gender'] == 'male') {
                $DB['gender'] = 2;
            } else if ($post['gender'] == 'female') {
                $DB['gender'] = 1;
            } else {
                $DB['gender'] = 0;
            }
            $DB['avatar'] = 'https://graph.facebook.com/' . $post['id'] . '/picture?type=large';
            $DB['login'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $check = $this->user->getUser('', $DB['email'], '', $DB['facebook']);
            if ($check) {
                $id = $check->id;
                $id = $this->user->saveUser($DB, $id);
                $user = $this->user->getUser($id);
                $user->b2b = false;
                $this->session->set_userdata('user', $user);
            } else {
                $DB['dt_create'] = date('Y-m-d H:i:s');
                $DB['type'] = 1;
                $DB['groups'] = 2; //1: register - 2: facebook - 3: google
                $id = $this->user->saveUser($DB);
                $user = $this->user->getUser($id);
                $user->b2b = false;
                $this->session->set_userdata('user', $user);
            }
            $this->session->set_userdata('isLoginSite', true);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        header('Content-Type: application/json');
        echo json_encode($data);
        return;
    }

    function logout(){
        /** Login*/
        $Login = array('isLoginSite', 'user', 'email', 'password');
        $this->session->unset_userdata($Login);
        /** UserID to payment gold member*/
        /*$this->session->unset_userdata('userid');
        $this->session->unset_userdata('payment');*/
        /** Order*/
        /*$this->cart->destroy();
        $this->session->unset_userdata('orderID');
        $this->session->unset_userdata('ID');*/
        /** Invitation*/
        /*$Invitation = array('datingID' => '', 'invita' => '', 'listUser' => '');
        $this->session->unset_userdata($Invitation);*/
        /** Clear session search USER */
        /*$SearchUser = array('year_from' => '', 'year_to' => '', 'height_from' => '', 'height_to' => ''
        , 'gender' => '', 'relationship' => '', 'children' => '', 'ethnic_origin' => ''
        , 'religion' => '', 'training' => '', 'body' => '');
        $this->session->unset_userdata($SearchUser);*/

        setcookie('cc_data', '', -time() + (86400 * 30), "/");

        redirect(site_url());
    }

    /** Action function*/



    /**
     * @param int $page
     * @return view layout
     */
    function sentkisses($page = 0)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        /** Clear session search USER */
        $SearchUser = array('year_from' => '', 'year_to' => '', 'height_from' => '', 'height_to' => ''
        , 'gender' => '', 'relationship' => '', 'children' => '', 'ethnic_origin' => ''
        , 'religion' => '', 'training' => '', 'body' => '');
        $this->session->unset_userdata($SearchUser);

        $data['user'] = $this->session->userdata('user');
        $config['base_url'] = base_url() . $this->language . '/user/sentkiss/';
        $config['total_rows'] = $this->user->getNumSentKiss($data['user']->id);
        $config['per_page'] = $this->config->item('numberpage');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $listUsers = $this->user->getSentKiss($config['per_page'], (int)$page, $data['user']->id);
        $data['pagination'] = $this->pagination->create_links();
        if ($listUsers) {
            $i = 0;
            foreach ($listUsers as $row) {
                $users[$i]['id'] = $row->id;
                $users[$i]['name'] = $row->name;
                $users[$i]['birthday'] = $row->birthday;
                $users[$i]['code'] = $row->code;
                $users[$i]['send_at'] = $row->send_at;
                $users[$i]['facebook'] = $row->facebook;
                if ($row->facebook && $row->avatar) {
                    $users[$i]['avatar'] = $row->avatar;
                } else {
                    $photo = $this->user->getPhoto($row->id);
                    if ($photo) {
                        $users[$i]['avatar'] = $photo[0]->image;
                    } else {
                        $users[$i]['avatar'] = "";
                    }
                }
                $i++;
            }
        } else {
            $users = "";
        }
        $data['list'] = $users;

        $data['page'] = 'user/sentkisses';
        $this->load->view('templates', $data);
    }

    /**
     * @param int $page
     * @return load view layout
     */
    function receivedkisses($page = 0)
    {
        $data = array();
        $this->user->addMeta($this->_meta, $data);

        /** Clear session search USER */
        $SearchUser = array('year_from' => '', 'year_to' => '', 'height_from' => '', 'height_to' => ''
        , 'gender' => '', 'relationship' => '', 'children' => '', 'ethnic_origin' => ''
        , 'religion' => '', 'training' => '', 'body' => '');
        $this->session->unset_userdata($SearchUser);

        $data['user'] = $this->session->userdata('user');
        $config['base_url'] = base_url() . $this->language . '/user/receivedkisses/';
        $config['total_rows'] = $this->user->getNumReceivedKisses($data['user']->id);
        $config['per_page'] = $this->config->item('numberpage');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $listUsers = $this->user->getReceivedKisses($config['per_page'], (int)$page, $data['user']->id);
        $data['pagination'] = $this->pagination->create_links();
        if ($listUsers) {
            $i = 0;
            foreach ($listUsers as $row) {
                $users[$i]['id'] = $row->id;
                $users[$i]['name'] = $row->name;
                $users[$i]['birthday'] = $row->birthday;
                $users[$i]['code'] = $row->code;
                $users[$i]['send_at'] = $row->send_at;
                $users[$i]['facebook'] = $row->facebook;
                if ($row->facebook && $row->avatar) {
                    $users[$i]['avatar'] = $row->avatar;
                } else {
                    $photo = $this->user->getPhoto($row->id);
                    if ($photo) {
                        $users[$i]['avatar'] = $photo[0]->image;
                    } else {
                        $users[$i]['avatar'] = "";
                    }
                }
                $i++;
            }
        } else {
            $users = "";
        }
        $data['list'] = $users;

        $data['page'] = 'user/receivedkisses';
        $this->load->view('templates', $data);
    }

    public function changePerPage(){
        $perPage = $this->input->post('perPage');
        $this->session->set_userdata('perPage', $perPage);
        redirect($_SERVER['HTTP_REFERER']);
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
        customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Den person er tilføjet til vennelisten');
    }

    public function rejectAddFriend($profileId){
        $user = $this->session->userdata('user');
        $this->user->updateFriendRequest($user->id, $profileId, 2);
        customRedirectWithMessage($_SERVER['HTTP_REFERER'], 'Den pågældende afvises til vennelisten');
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