<?php
/** API Zeduuce 2016 - Lê Đức Cường - Skype: lecuong2585*/
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Api extends MX_Controller{
    private $getData = array();
    private $header = '';
    function __construct(){
        parent::__construct();
        $this->load->model('api_model','api');
        $this->load->model('general_model', 'general');
        $this->load->model('user_model', 'user');
        $this->load->library('user_agent');
        parse_str($_SERVER['QUERY_STRING'], $getData);
        $this->getData = $this->security->xss_clean($getData);
        $lang = $this->lang->lang();
        $this->header = getallheaders();
    }
    function index($id=0){
        echo 'API Zeduuce.com';
        echo "<pre>";
        print_r($this->getData);
    }
    function device(){
        #$token['csrf_site_name'] = $this->security->get_csrf_hash();
        #$data['message'] = '';
        #$data['error'] = false;
        #$data['data'] = $token;
        #print_r($this->header);die;
        #$file = fopen( $this->config->item('root')."/uploads/login.txt","a+");
        #$contentLog = date('Y-m-d H:s:i')."-Header: ".$this->header['token'].PHP_EOL;
        #fwrite($file,$contentLog);
        #fclose($file);
        $device = $this->input->post('device');
        $token = $this->input->post('token');
        $platform = $this->input->post('platform');
        $check = $this->api->checkDevice($token);
        if($check){
            $data['message'] = 'Has added!';
            $data['error'] = true;
            $data['data'] = $check->id;
        }else{
            $DB['device'] = $device;
            $DB['token'] = $token;
            $DB['platform'] = $platform;
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $id = $this->api->insertDevice($DB);
            if($id){
                $data['message'] = 'OK. Go!';
                $data['error'] = false;
                $data['data'] = $id;
            }else{
                $data['message'] = 'Can not add divice!';
                $data['error'] = true;
                $data['data'] = array();
            }
        }
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    /** HOME PAGES --------------------------------------------------------------------------------*/
    function home($userID=NULL){
        if($userID){
            $ignore[] = $userID;
        }else{
            $ignore = "";
        }
        $users = $this->api->getUserList(20,0,NULL,$ignore);
        if($users){
            $i=0;
            foreach($users as $row){
                $user[$i]['id'] = (int)$row->id;
                $user[$i]['name'] = $row->name;
                $user[$i]['email'] = $row->email;
                $user[$i]['gender'] = $row->gender;
                $user[$i]['birthday'] = $row->birthday;
                $user[$i]['height'] = $row->height;
                $user[$i]['relationship'] = $row->relationship;
                $user[$i]['children'] = $row->children;
                $user[$i]['ethnic_origin'] = $row->ethnic_origin;
                $user[$i]['religion'] = $row->religion;
                $user[$i]['training'] = $row->training;
                $user[$i]['body'] = $row->body;
                $user[$i]['description'] = $row->description;
                $user[$i]['slogan'] = $row->slogan;
                $user[$i]['code'] = $row->code;
                $user[$i]['type'] = $row->type;
                $user[$i]['facebook'] = $row->facebook;
                /*if($row->avatar){
                    if($row->facebook){
                        $user[$i]['avatar'] = $row->avatar;
                    }else{
                        $user[$i]['avatar'] = base_url()."uploads/user/".$row->avatar;
                    }
                }else{
                    $user[$i]['avatar'] = '';
                }*/
                if($row->facebook && $row->avatar){
                    $user[$i]['avatar'] = $row->avatar;
                }else{
                    $photo = $this->user->getPhoto($row->id);
                    if($photo){
                        $user[$i]['avatar'] = base_url()."uploads/photo/".$photo[0]->image;
                    }else{
                        $user[$i]['avatar'] = "";
                    }
                }
                $i++;
            }
        }else{
            $user = array();
        }
        $result['user'] = $user;
        $products = $this->api->getProduct();
        if($products){
            $i=0;
            foreach($products as $row){
                $product[$i]['id'] = (int)$row->id;
                $product[$i]['name'] = $row->name;
                $product[$i]['description'] = $row->description;
                $product[$i]['content'] = $row->content;
                if($row->image){
                    $product[$i]['image'] = base_url()."uploads/product/".$row->image;
                }else{
                    $product[$i]['image'] = '';
                }
                $product[$i]['price'] = $row->price;
                $product[$i]['company'] = $row->company;
                $product[$i]['address'] = $row->address;
                $i++;
            }
        }else{
            $product = array();
        }
        $result['product'] = $product;
        $wel = $this->general_model->getNewsStatic('velkommen');
        if($wel){
            $result['velkommen']['name'] = $wel->title;
            $result['velkommen']['content'] = $wel->content;
        }else{
            $result['velkommen'] = array();
        }
        $blivGratis = $this->general_model->getNewsStatic('blivgratis');
        if($blivGratis){
            $result['blivGratis']['name'] = $blivGratis->title;
            $result['blivGratis']['content'] = $blivGratis->content;
        }else{
            $result['blivGratis'] = array();
        }
        $blivBetalende = $this->general_model->getNewsStatic('blivbetalende');
        if($blivBetalende){
            $result['blivBetalende']['name'] = $blivBetalende->title;
            $result['blivBetalende']['content'] = $blivBetalende->content;
        }else{
            $result['blivBetalende'] = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($result);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function contact(){
        //Send mail
        $DB['name'] = $this->input->post('name');
        $DB['phone'] = $this->input->post('phone');
        $DB['email'] = $this->input->post('email');
        $DB['besked'] = $this->input->post('besked');
        $admin = $this->config->item('email');
        $emailTo = array($DB['email'],$admin);
        sendEmail($emailTo,'contact',$DB,'');
        //Save DB
        $DB['dt_create'] = date('Y-m-d H:i:s');
        $DB['bl_active'] = 1;
        $id = $this->general_model->saveContact($DB);
        if($id){
            $data['message'] = '';
            $data['error'] = false;
            $data['data'] = $id;
        }else{
            $data['message'] = '';
            $data['error'] = true;
            $data['data'] = array();
        }
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function content($type){
        if($type=='om'){
            $id = 9;
        }else if($type=='faq'){
            $id = 10;
        }else if($type == 'handelsbetingelser'){
            $id = 8;
        }else{
            $id = 0;
        }
        $item = $this->general_model->getNewsStaticID($id);
        if($item){
            $content['id'] = (int)$item->id;
            $content['title'] = $item->title;
            $content['content'] = $item->content;
        }else{
            $content = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $content;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    /** USER --------------------------------------------------------------------------------------*/
    function login(){
        $email = $this->input->post('email', true);
        $pass = md5($this->input->post('password', true));
        //Check
        $user = $this->api->getUser(NULL,$email,$pass);
        if($user){
            $result['id'] = (int)$user->id;
            $result['name'] = $user->name;
            $result['email'] = $user->email;
            $result['gender'] = $user->gender;
            $result['birthday'] = $user->birthday;
            $result['height'] = $user->height;
            $result['relationship'] = $user->relationship;
            $result['children'] = $user->children;
            $result['ethnic_origin'] = $user->ethnic_origin;
            $result['religion'] = $user->religion;
            $result['training'] = $user->training;
            $result['body'] = $user->body;
            $result['description'] = $user->description;
            $result['slogan'] = $user->slogan;
            $result['code'] = $user->code;
            $result['type'] = $user->type;
            $result['facebook'] = $user->facebook;
            if($user->avatar){
                if($user->facebook){
                    $result['avatar'] = $user->avatar;
                }else{
                    $result['avatar'] = base_url()."uploads/user/".$user->avatar;
                }
            }else{
                $result['avatar'] = '';
            }
            $data['message'] = '';
            $data['error'] = false;
            $data['data'] = $result;
            $this->api->updateLogin($user->id);
        }else{
            $data['message'] = '';
            $data['error'] = true;
            $data['data'] = array();
        }
        #$file = fopen( $this->config->item('root')."/uploads/login.txt","a+");
        #$contentLog = date('Y-m-d H:s:i')."-Header: ".$this->header['token'].PHP_EOL;
        #fwrite($file,$contentLog);
        #fclose($file);
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function loginFB(){
        $ID = $this->input->post('id', true);
        $DB['email'] = $this->input->post('email', true);
        $DB['name'] = $this->input->post('name', true);
        $DB['avatar'] = $this->input->post('avatar', true);
        $DB['device'] = $this->input->post('device',true);
        //Facebook
        if($ID){
            $user = $this->api->getUser(NULL,NULL,NULL,$ID);
            $DB['facebook'] = $ID;
            $DB['avatar'] = 'https://graph.facebook.com/'.$ID.'/picture?type=large';
            $DB['login'] = date('Y-m-d H:i:s');
            if($user){
				$id = $user->id;
				$update = $this->api->saveUser($DB,$id);
                $result['id'] = (int)$user->id;
                $result['name'] = $user->name;
                $result['email'] = $user->email;
                $result['gender'] = $user->gender;
                $result['birthday'] = $user->birthday;
                $result['height'] = $user->height;
                $result['relationship'] = $user->relationship;
                $result['children'] = $user->children;
                $result['ethnic_origin'] = $user->ethnic_origin;
                $result['religion'] = $user->religion;
                $result['training'] = $user->training;
                $result['body'] = $user->body;
                $result['description'] = $user->description;
                $result['slogan'] = $user->slogan;
                $result['code'] = $user->code;
                $result['type'] = $user->type;
                $result['facebook'] = $user->facebook;
                if($user->avatar){
                    $result['avatar'] = $user->avatar;
                }else{
                    $result['avatar'] = '';
                }
            }else{
                $DB['dt_create'] = date('Y-m-d H:i:s');
                $DB['bl_active'] = 1;
                $DB['type'] = 1;
                $DB['groups'] = 2; //1: register - 2: facebook - 3: google
				$id = $this->api->saveUser($DB);
				$user = $this->api->getUser($id);
                $result['id'] = (int)$user->id;
                $result['name'] = $user->name;
                $result['email'] = $user->email;
                $result['gender'] = $user->gender;
                $result['birthday'] = $user->birthday;
                $result['height'] = $user->height;
                $result['relationship'] = $user->relationship;
                $result['children'] = $user->children;
                $result['ethnic_origin'] = $user->ethnic_origin;
                $result['religion'] = $user->religion;
                $result['training'] = $user->training;
                $result['body'] = $user->body;
                $result['description'] = $user->description;
                $result['slogan'] = $user->slogan;
                $result['code'] = $user->code;
                $result['type'] = $user->type;
                $result['facebook'] = $user->facebook;
                if($user->avatar){
                    $result['avatar'] = $user->avatar;
                }else{
                    $result['avatar'] = '';
                }
			}  
        }else{
            $result = array();
            $data['message'] = 'Kan ikke logge ind!';
            $data['error'] = true;
            $data['data'] = $result;
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function profile($user){
        //USER
        $users = $this->api->getUser($user);
        if($users){
            $u['id'] = (int)$users->id;
            $u['name'] = $users->name;
            $u['email'] = $users->email;
            $u['gender'] = $users->gender;
            $u['birthday'] = $users->birthday;
            $u['height'] = $users->height;
            $u['relationship'] = $users->relationship;
            $u['children'] = $users->children;
            $u['ethnic_origin'] = $users->ethnic_origin;
            $u['religion'] = $users->religion;
            $u['training'] = $users->training;
            $u['body'] = $users->body;
            $u['description'] = $users->description;
            $u['slogan'] = $users->slogan;
            $u['code'] = $users->code;
            $u['type'] = $users->type;
            $u['facebook'] = $users->facebook;
            if($users->avatar){
                if($users->facebook){
                    $u['avatar'] = $users->avatar;
                }else{
                    $u['avatar'] = base_url()."uploads/user/".$users->avatar;
                }
            }else{
                $u['avatar'] = '';
            }
            $result['user'] = $u;
        }else{
            $result['user'] = array();
        }
        //BOX
        $tilbuds = $this->api->getMyTilbud($users->id);
        if($tilbuds){
            $i=0;
            foreach($tilbuds as $row){
                $tilbud[$i]['id'] = (int)$row->product_id;
                $tilbud[$i]['name'] = $row->product_name;
                $tilbud[$i]['image'] = base_url()."uploads/product/".$row->image;
                $i++;
            }
            $result['tilbud'] = $tilbud;
        }else{
            $result['tilbud'] = array();
        }
        $wishlists = $this->api->getWishlist($users->id);
        if($wishlists){
            $i=0;
            foreach($wishlists as $row){
                $wishlist[$i]['id'] = (int)$row->id;
                $wishlist[$i]['name'] = $row->name;
                $wishlist[$i]['image'] = base_url()."uploads/product/".$row->image;
                $i++;
            }
            $result['wishlist'] = $wishlist;
        }else{
            $result['wishlist'] = array();
        }
        //IMAGE
        $photos = $this->api->getPhoto($users->id);
        if($photos){
            $i=0;
            foreach($photos as $row){
                $photo[$i]['id'] = (int)$row->id;
                $photo[$i]['image'] = base_url()."uploads/photo/".$row->image;
                $i++;
            }
            $result['photo'] = $photo;
        }else{
            $result['photo'] = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function register(){
        $DB['name'] = $this->input->post('name');
        $DB['email'] = $this->input->post('email');
        $DB['password'] = md5($this->input->post('password'));
        $DB['code'] = $this->input->post('code');
        $DB['day'] = $this->input->post('day');
        $DB['month'] = $this->input->post('month');
        $DB['year'] = $this->input->post('year');
        $DB['device'] = $this->input->post('device');
        $DB['birthday'] = $this->input->post('day').'/'.$this->input->post('month').'/'.$this->input->post('year');
        $DB['type'] = 1;
        $DB['groups'] = 1; //1: register - 2: facebook - 3: google
        $DB['bl_active'] = 1;
        $DB['dt_create'] = date('Y-m-d H:i:s');
        $type = $this->input->post('type');
        //Check email when register
        $user = $this->api->getUser(NULL,$DB['email'],NULL,NULL,NULL,1);
        if($user){
            $data['message'] = 'E-mail er allerede registeret!';
            $data['error'] = true;
            $data['data'] = array();
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $id = $this->api->saveUser($DB);
        if($id){
            $users = $this->api->getUser($id,$DB['email'],$DB['password']);
            if($users){
                $result['id'] = (int)$users->id;
                $result['name'] = $users->name;
                $result['email'] = $users->email;
                $result['gender'] = $users->gender;
                $result['birthday'] = $users->birthday;
                $result['height'] = $users->height;
                $result['relationship'] = $users->relationship;
                $result['children'] = $users->children;
                $result['ethnic_origin'] = $users->ethnic_origin;
                $result['religion'] = $users->religion;
                $result['training'] = $users->training;
                $result['body'] = $users->body;
                $result['description'] = $users->description;
                $result['slogan'] = $users->slogan;
                $result['code'] = $users->code;
                $result['type'] = $users->type;
                $result['facebook'] = $users->facebook;
                if($users->avatar){
                    if($users->facebook){
                        $result['avatar'] = $users->avatar;
                    }else{
                        $result['avatar'] = base_url()."uploads/user/".$users->avatar;
                    }
                }else{
                    $result['avatar'] = '';
                }
                if($type == 2){
                    $result['orderID'] = 'US-'.randomPassword();
                    $result['total'] = $this->config->item('priceuser');
                    $DBs['orderid'] = $result['orderID'];
                    $DBs['price'] = $result['total'];
                    $this->api->saveUser($DBs,$id);
                }else{
                    $result['orderID'] = '';
                    $result['total'] = 0;
                }
                $data['message'] = '';
                $data['error'] = false;
                $data['data'] = $result;
            }else{
                $data['message'] = '';
                $data['error'] = true;
                $data['data'] = array();
            }   
        }else{
            $data['message'] = '';
            $data['error'] = true;
            $data['data'] = array();
        }
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function updateUser($id=NULL){
        if($this->input->post()){
            $userID = $this->input->post('id');
            $DB['name'] = $this->input->post('name');
            $DB['day'] = $this->input->post('day');
            $DB['month'] = $this->input->post('month');
            $DB['year'] = $this->input->post('year');
            $DB['birthday'] = $this->input->post('day').'/'.$this->input->post('month').'/'.$this->input->post('year');
            $DB['code'] = $this->input->post('code');
            $DB['gender'] = $this->input->post('gender');
            $DB['height'] = $this->input->post('height');
            $DB['relationship'] = $this->input->post('relationship');
            $DB['children'] = $this->input->post('children');
            $DB['ethnic_origin'] = $this->input->post('ethnic_origin');
            $DB['religion'] = $this->input->post('religion');
            $DB['training'] = $this->input->post('training');
            $DB['body'] = $this->input->post('body');
            $DB['slogan'] = $this->input->post('slogan');
            $DB['description'] = $this->input->post('description');
            if($this->input->post('password')&&$this->input->post('repassword')){
                if($this->input->post('password')!=$this->input->post('repassword')){
                    //$this->session->set_flashdata('message',"Password incorrect");
                    $data['message'] = 'Password incorrect';
                    $data['error'] = true;
                    $data['data'] = array();
                    header('content-type: application/json; charset=utf-8');
                    echo json_encode($data);return;
                }else{
                    $DB['password'] = md5($this->input->post('password'));
                }
            }
            if($id!=$userID){
                $data['message'] = 'User ID incorrect';
                $data['error'] = true;
                $data['data'] = array();
                header('content-type: application/json; charset=utf-8');
                echo json_encode($data);return;
            }
            $id = $this->api->saveUser($DB,$userID);
            if($id){
                #$data['message'] = 'Update successful';
                #$data['error'] = false;
                #$data['data'] = $id;
                #header('content-type: application/json; charset=utf-8');
                #echo json_encode($data);return;
                //Continue ...
            }else{
                $data['message'] = 'Update error!';
                $data['error'] = true;
                $data['data'] = array();
                header('content-type: application/json; charset=utf-8');
                echo json_encode($data);return;
            }
        }
        $user = $this->api->getUser($id);
        if($user){
            $result['id'] = (int)$user->id;
            $result['name'] = $user->name;
            $result['email'] = $user->email;
            $result['gender'] = $user->gender;
            $result['birthday'] = $user->birthday;
            $result['height'] = $user->height;
            $result['relationship'] = $user->relationship;
            $result['children'] = $user->children;
            $result['ethnic_origin'] = $user->ethnic_origin;
            $result['religion'] = $user->religion;
            $result['training'] = $user->training;
            $result['body'] = $user->body;
            $result['description'] = $user->description;
            $result['slogan'] = $user->slogan;
            $result['code'] = $user->code;
            $result['type'] = $user->type;
            $result['paymenttime'] = $user->paymenttime;
            $result['facebook'] = $user->facebook;
            if($user->avatar){
                if($user->facebook){
                    $result['avatar'] = $user->avatar;
                }else{
                    $result['avatar'] = base_url()."uploads/user/".$user->avatar;
                }
            }else{
                $result['avatar'] = '';
            }
        }else{
            $result = array();
        }
        $data['message'] = 'Update successful';
        $data['error'] = false;
        $data['data'] = $result;
            
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function upgrade($user){
        $users = $this->api->getUser($user);
        if($users){
            $result['orderID'] = 'US-'.randomPassword();
            $DBs['orderid'] = $result['orderID'];
            $DBs['price'] =  $this->config->item('priceuser');
            $this->api->saveUser($DBs,$user);
            $result['total'] = $this->config->item('priceuser');
            $data['message'] = '';
            $data['error'] = false;
            $data['data'] = $result;
        }else{
            $data['message'] = 'User incorrect!';
            $data['error'] = true;
            $data['data'] = array();
        }
        
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function positiv($user){
        $users = $this->api->getPositiv(null,NULL,$user);
        if($users){
            $i=0;
            foreach($users as $row){
                $result[$i]['id'] = (int)$row->id;
                $result[$i]['name'] = $row->name;
                $result[$i]['email'] = $row->email;
                $result[$i]['gender'] = $row->gender;
                $result[$i]['birthday'] = $row->birthday;
                $result[$i]['height'] = $row->height;
                $result[$i]['relationship'] = $row->relationship;
                $result[$i]['children'] = $row->children;
                $result[$i]['ethnic_origin'] = $row->ethnic_origin;
                $result[$i]['religion'] = $row->religion;
                $result[$i]['training'] = $row->training;
                $result[$i]['body'] = $row->body;
                $result[$i]['description'] = $row->description;
                $result[$i]['slogan'] = $row->slogan;
                $result[$i]['code'] = $row->code;
                $result[$i]['type'] = $row->type;
                $result[$i]['facebook'] = $row->facebook;
                if($row->avatar){
                    if($row->facebook){
                        $result[$i]['avatar'] = $row->avatar;
                    }else{
                        $result[$i]['avatar'] = base_url()."uploads/user/".$row->avatar;
                    }
                }else{
                    $result[$i]['avatar'] = '';
                }
                $i++;
            }
        }else{
            $result = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function browsing($page=0,$user=NULL){
        $year = date('Y', time());
        $year_from = $this->input->post('year_to');
        $year_to = $this->input->post('year_from');
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
        if($year_from){
            $year_from = $year - $this->input->post('year_to');
            $search_1 = array('year_from' => $year_from);
        }else{
            $search_1 = array();
        }
        if($year_to){
            $year_to = $year - $this->input->post('year_from');
            $search_2 = array('year_to' => $year_to);
        }else{
            $search_2 = array();
        }
        if($height_from){
            $search_3 = array('height_from' => $height_from);
        }else{
            $search_3 = array(1);
        }
        if($height_to){
            $search_4 = array('height_to' => $height_to);
        }else{
            $search_4 = array();
        }
        if($gender){
            $search_5 = array('gender' => $gender);
        }else{
            $search_5 = array();
        }
        if($relationship){
            $search_6 = array('relationship' => $relationship);
        }else{
            $search_6 = array();
        }
        if($children){
            $search_7 = array('children' => $children);
        }else{
            $search_7 = array();
        }
        if($ethnic_origin){
            $search_8 = array('ethnic_origin' => $ethnic_origin);
        }else{
            $search_8 = array();
        }
        if($religion){
            $search_9 = array('religion' => $religion);
        }else{
            $search_9 = array();
        }
        if($training){
            $search_10 = array('training' => $training);
        }else{
            $search_10 = array();
        }
        if($body){
            $search_11 = array('body' => $body);
        }else{
            $search_11 = array();
        }
        $search = array_merge($search_1,$search_2,$search_3,$search_4,$search_5,$search_6,$search_7,$search_8,$search_9,$search_10,$search_11);
        if($user){
            $ignore[] = $user;
        }else{
            $ignore = "";
        }
        $config['base_url'] = base_url().'/api/browsing/';
        $config['total_rows'] = $this->api->getNumBrowsing($search,$ignore);
        $config['per_page'] = 30;//$this->config->item('numberpage');
        $config['num_links'] = 2;
        $config['uri_segment'] = $this->uri->total_segments();
        $this->pagination->initialize($config);
        $pages = $page*30;
        $users = $this->api->getBrowsing($config['per_page'],(int)$pages,$search,$ignore);
        #$data['pagination'] = $this->pagination->create_links();
        #$users = $this->api->getBrowsing(NULL,NULL,$search,$ignore);
        if($users){
            $i=0;
            foreach($users as $row){
                $result[$i]['id'] = (int)$row->id;
                $result[$i]['name'] = $row->name;
                $result[$i]['email'] = $row->email;
                $result[$i]['gender'] = $row->gender;
                $result[$i]['birthday'] = $row->birthday;
                $result[$i]['height'] = $row->height;
                $result[$i]['relationship'] = $row->relationship;
                $result[$i]['children'] = $row->children;
                $result[$i]['ethnic_origin'] = $row->ethnic_origin;
                $result[$i]['religion'] = $row->religion;
                $result[$i]['training'] = $row->training;
                $result[$i]['body'] = $row->body;
                $result[$i]['description'] = $row->description;
                $result[$i]['slogan'] = $row->slogan;
                $result[$i]['code'] = $row->code;
                $result[$i]['type'] = $row->type;
                $result[$i]['paymenttime'] = $row->paymenttime;
                $result[$i]['facebook'] = $row->facebook;
                if($row->avatar){
                    if($row->facebook){
                        $result[$i]['avatar'] = $row->avatar;
                    }else{
                        $result[$i]['avatar'] = base_url()."uploads/user/".$row->avatar;
                    }
                }else{
                    $result[$i]['avatar'] = '';
                }
                $check = $this->api->checkFavorite($user,$row->id);
                if($check){
                    $result[$i]['favorite'] = "1";
                }else{
                    $result[$i]['favorite'] = "0";
                }
                $i++;
            }
        }else{
            $result = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function forGotPass(){
        $email = $this->input->post('email');
        $user = $this->api->getUser('',$email);
        if($user){
            $pass = randomPassword();
            $DB['password'] = md5($pass);
            $id = $this->api->saveUser($DB,$user->id);
            if($id){
                $data['message'] = 'Change password ok!';
                $data['error'] = false;
                $data['data'] = $user;
                //Send mail to user
                
            }else{
                $data['message'] = 'Change password error!';
                $data['error'] = true;
                $data['data'] = $user;
            }
        }else{
            $data['message'] = 'Email not available in system!';
            $data['error'] = true;
            $data['data'] = array();
        }
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    /** MESSAGE ------------------------------------------------------------------------------------*/
    function myMessages($user){
        $message = $this->api->getListMessage($user);
        $result = "";
        if($message){
            $i = 0;
            foreach($message as $row){
                $userSend = $this->api->getUser($row->user_from);
                if($userSend){
                    $result[$i]['id'] = $userSend->id;
                    $result[$i]['name'] = $userSend->name;
                    $result[$i]['email'] = $userSend->email;
                    $result[$i]['notSeen'] = $this->api->getNotSeen($user,$row->user_from);
                    $latestMessage = $this->api->getLatestMessage($user,$row->user_from);
                    $result[$i]['message'] = $latestMessage->message;
                    $result[$i]['date'] = $latestMessage->dt_create;
                    $i++;
                }
            }
        }
        $data['message'] = 'List messages!';
        $data['error'] = false;
        $data['data'] = $result;
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function messages($user, $id){
        $messages = $this->api->getMessages($user,$id);
        $this->api->clearNotSeen($user,$id);
        if($messages){
            $i = 0;
            foreach($messages as $row){
                $result[$i]['id'] = $row->id;
                $result[$i]['name'] = $row->name;
                $result[$i]['message'] = $row->message;
                $result[$i]['date'] = $row->dt_create;
                $i++;
            }
        }else{
            $result = array();
        }
        $data['message'] = 'Messages!';
        $data['error'] = false;
        $data['data'] = $result;
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function sendMessages(){
        $DB['user_from'] = $this->input->post('userfrom');
        $DB['user_to'] = $this->input->post('userto');
        $DB['message'] = $this->input->post('message');
        $DB['seen'] = 1;
        $DB['dt_create'] = date('Y-m-d H:i:s');
        $DB['bl_active'] = 1;
        
        $this->api->saveMessage($DB);
        $item = $this->api->getUser($DB['user_from']);
        actionUser($DB['user_from'],$DB['user_to'],'Message',3);
        
        $result['name'] = $item->name;
        $result['message'] = $DB['message'];
        $result['date'] = $DB['dt_create'];
        $data['message'] = 'Messages!';
        $data['error'] = false;
        $data['data'] = $result;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function deleteMessage(){
        $userFrom = $this->input->post('userfrom');
        $userTo = $this->input->post('userto');
        $this->api->deleteMessage_FT($userFrom,$userTo);
        $this->api->deleteMessage_TF($userFrom,$userTo);
        $data['message'] = 'Delete ok!';
        $data['error'] = false;
        $data['data'] = array();
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    
    /** PHOTO -------------------------------------------------------------------------------------*/
    function myPhoto($user){
        $photo = $this->api->getPhoto($user);
        if($photo){
            $i=0;
            foreach($photo as $row){
                $result[$i]['id'] = (int)$row->id;
                $result[$i]['image'] = base_url()."uploads/photo/".$row->image;
                $i++;
            }
        }else{
            $result = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
            
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function uploadPhoto($user){
        $config['upload_path'] = $this->config->item('root')."uploads/photo/";
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= $this->config->item('maxupload');
		$config['encrypt_name']	= TRUE;  //rename to random string image
        $this->load->library('upload', $config);
        $myImage = $this->input->post('myImage');
        if($myImage){
            $list = explode("&",$myImage);
            for($i=0;$i<count($list);$i++){
                if(isset($_FILES[$list[$i]]['name'])){
                    $nameImage = $this->upload->do_upload($list[$i]);
        			if ($nameImage){
                        $dataImg = $this->upload->data();
        				$mgList[$i]['name'] = $dataImg['file_name'];
        			}else {
        				$data['message'] = 'Upload failed!';
                        $data['error'] = true;
                        $data['data'] = array();
                        header('content-type: application/json; charset=utf-8');
                        echo json_encode($data);
                        return;
        			}
        		}
            }
            $DB['userID'] = $user;
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            if($mgList){
                foreach($mgList as $row){
                    $DB['image'] = $row['name'];
                    $id = $this->api->savePhoto($DB);
                }
                $photo = $this->api->getPhoto($user);
                if($photo){
                    $i=0;
                    foreach($photo as $row){
                        $result[$i]['id'] = (int)$row->id;
                        $result[$i]['image'] = base_url()."uploads/photo/".$row->image;
                        $i++;
                    }
                }else{
                    $result = array();
                }
                $data['message'] = 'Upload OK.';
                $data['error'] = false;
                $data['data'] = $result;
            }else{
                $data['message'] = 'No images!';
                $data['error'] = true;
                $data['data'] = array();
            } 
        }else{
            $data['message'] = 'Error! No file upload!';
            $data['error'] = true;
            $data['data'] = array();
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function deletePhoto($user){
        $images = $this->input->post('image');
        //$image = json_decode($imagePost,true);
        if($images){
            for($i=0;$i<count($images); $i++){
                $this->api->deletePhoto($images[$i],$user);
            }
            $data['message'] = 'OK. Go!';
            $data['error'] = false;
            $data['data'] = array();
        }else{
            $data['message'] = 'No post data!';
            $data['error'] = true;
            $data['data'] = array();
        }
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    /** FAVORITE ----------------------------------------------------------------------------------*/
    function favorite($id=NULL){
        $favorites = $this->api->getFavorite(NULL,NULL,$id);
        if($favorites){
            $i=0;
            foreach($favorites as $row){
                $result[$i]['id'] = (int)$row->id;
                $result[$i]['name'] = $row->name;
                $result[$i]['email'] = $row->email;
                $result[$i]['gender'] = $row->gender;
                $result[$i]['birthday'] = $row->birthday;
                $result[$i]['height'] = $row->height;
                $result[$i]['relationship'] = $row->relationship;
                $result[$i]['children'] = $row->children;
                $result[$i]['ethnic_origin'] = $row->ethnic_origin;
                $result[$i]['religion'] = $row->religion;
                $result[$i]['training'] = $row->training;
                $result[$i]['body'] = $row->body;
                $result[$i]['description'] = $row->description;
                $result[$i]['slogan'] = $row->slogan;
                $result[$i]['code'] = $row->code;
                $result[$i]['type'] = $row->type;
                $result[$i]['paymenttime'] = $row->paymenttime;
                $result[$i]['facebook'] = $row->facebook;
                if($row->avatar){
                    if($row->facebook){
                        $result[$i]['avatar'] = $row->avatar;
                    }else{
                        $result[$i]['avatar'] = base_url()."uploads/user/".$row->avatar;
                    }
                    $result[$i]['avatar'] = base_url()."uploads/user/".$row->avatar;
                }else{
                    $result[$i]['avatar'] = '';
                }
                $result[$i]['favorite'] = "1";
                $i++;
            }
        }else{
            $result = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;

        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function addFavorite(){
        $userID = $this->input->post('user',true);
        $user = $this->input->post('id',true);
        $check = $this->api->checkFavorite($user,$userID);
        if($check){
            $data['message'] = 'Has added!';
            $data['error'] = true;
            $data['data'] = array();
        }else{
            $DB['user_from'] = $user;
            $DB['user_to'] = $userID;
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $id = $this->api->addFavorite($DB);
            if($id){
                $data['message'] = '';
                $data['error'] = false;
                $data['data'] = $id;
            }else{
                $data['message'] = '';
                $data['error'] = true;
                $data['data'] = array();
            }
        }
        
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);  
    }
    function removeFavorite(){
        $userID = $this->input->post('user',true);
        $user = $this->input->post('id',true);
        if($user && $userID){
            $id = $this->api->removeFavorite($user,$userID);
            if($id){
                $data['message'] = '';
                $data['error'] = false;
                $data['data'] = $id;
            }else{
                $data['message'] = '';
                $data['error'] = true;
                $data['data'] = array();
            }
        }else{
            $data['message'] = '';
            $data['error'] = true;
            $data['data'] = array();
        }
        
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    /** SHOP PRODUCT ------------------------------------------------------------------------------*/
    function products($user=NULL){
        $categorys = $this->api->getCategory();
        if($categorys){
            $i=0;
            foreach($categorys as $row){
                $category[$i]['category_id'] = (int)$row->category_id;
                $category[$i]['name'] = $row->name;
                $i++;
            }
        }else{
            $category = array();
        }
        $result['category'] = $category;
        $products = $this->api->getProduct();
        if($products){
            $i=0;
            foreach($products as $row){
                $product[$i]['id'] = (int)$row->id;
                $product[$i]['name'] = $row->name;
                $product[$i]['description'] = $row->description;
                $product[$i]['content'] = $row->content;
                $product[$i]['image'] = base_url()."uploads/product/".$row->image;
                $product[$i]['price'] = $row->price;
                $product[$i]['company'] = $row->company;
                //$product[$i]['address'] = $row->address;
                if($user){
                    $check = $this->api->checkWishlist($user,$row->id);
                    if($check){
                        $product[$i]['wishlist'] = "1";
                    }else{
                        $product[$i]['wishlist'] = "0";
                    }
                }else{
                    $product[$i]['wishlist'] = "0";
                }
                $i++;
            }
        }else{
            $product = array();
        }
        $result['product'] = $product;
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function search($catID=NULL,$user=NULL){
        $categorys = $this->api->getCategory();
        if($categorys){
            $i=0;
            foreach($categorys as $row){
                $category[$i]['category_id'] = (int)$row->category_id;
                $category[$i]['name'] = $row->name;
                $i++;
            }
        }else{
            $category = array();
        }
        $result['category'] = $category;
        $search['category_id'] = $catID;
        //Key post search here
        
        $products = $this->api->getProduct(NULL,null,$search);
        if($products){
            $i=0;
            foreach($products as $row){
                $product[$i]['id'] = (int)$row->id;
                $product[$i]['name'] = $row->name;
                $product[$i]['description'] = $row->description;
                $product[$i]['content'] = $row->content;
                $product[$i]['image'] = base_url()."uploads/product/".$row->image;
                $product[$i]['price'] = $row->price;
                $product[$i]['company'] = $row->company;
                //$product[$i]['address'] = $row->address;
                if($user){
                    $check = $this->api->checkWishlist($user,$row->id);
                    if($check){
                        $product[$i]['wishlist'] = "1";
                    }else{
                        $product[$i]['wishlist'] = "0";
                    }
                }else{
                    $product[$i]['wishlist'] = "0";
                }
                $i++;
            }
        }else{
            $product = array();
        }
        $result['product'] = $product;
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function product($id=NULL){
        $pro = $this->api->getProductDetail($id);
        if($pro){
            $result['id'] = (int)$pro->id;
            $result['category_id'] = (int)$pro->category_id;
            $result['name'] = $pro->name;
            $result['description'] = $pro->description;
            $result['content'] = $pro->content;
            $result['image'] = base_url()."uploads/product/".$pro->image;
            $result['price'] = $pro->price;
            $result['address'] = $pro->companyAddress;
            $result['company'] = $pro->company;
            $image = $this->api->getProductImage($pro->id);
            if($image){
                foreach($image as $row){
                    $result['images'][] = base_url()."uploads/product/".$row->image;
                }
            }else{
                $result['images'] = array();
            }
        }else{
            $data['message'] = 'Khong ton tai san pham nay ma!';
            $data['error'] = true;
            $data['data'] = array();
            
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $search['category_id'] = $pro->category_id;
        $ignore[] = $id;
        $list = $this->api->getProduct(2,0,$search,$ignore);
        if($list){
            $i=0;
            foreach($list as $row){
                $proRelated[$i]['id'] = (int)$row->id;
                $proRelated[$i]['name'] = $row->name;
                $proRelated[$i]['description'] = $row->description;
                $proRelated[$i]['content'] = $row->content;
                $proRelated[$i]['image'] = base_url()."uploads/product/".$row->image;
                $proRelated[$i]['price'] = $row->price;
                //$proRelated[$i]['address'] = $row->address;
                $proRelated[$i]['company'] = $row->company;
                $i++;
            }
            $result['productRelated'] = $proRelated;
        }else{
            $result['productRelated'] = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function addToCart(){
        //NO DO
    }
    function order($user){
        #$cart = $this->cart->contents();
        #echo "<pre>";print_r($cart);die;
        #$cartPost = $this->input->post('cart');
        header('Content-type: application/json');
        $cartPost = file_get_contents('php://input');
        $cartTemp = json_decode($cartPost,true);
        $cart = $cartTemp['cart'];
        $total = 0;
        foreach($cart as $row){
            $total += ($row['qty']*$row['price']);
        }
        if($total == 0 || !$cart){
            $data['message'] = 'Cart is empty!';
            $data['error'] = true;
            $data['data'] = array();
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $DB['orderID'] = 'ZE-'.randomPassword();
        $DB['userID'] = $user;
        $DB['total'] = $total;
        $DB['bl_active'] = 0;
        $DB['dt_create'] = date('Y-m-d H:i:s');
        $ID = $this->api->saveOrder($DB);
        $catID = '';
        foreach($cart as $row){
            $pro = $this->api->getProductDetail($row['id']);
            $DBi['order_id'] = $ID;
            $DBi['product_id'] = $row['id'];
            $DBi['category_id'] = $pro->category_id;
            $catID .= $pro->category_id.",";
            $DBi['product_name'] = $pro->name;
            $DBi['quantity'] = $row['qty'];
            $DBi['price'] = $row['price'];
            $DBi['subtotal'] = $row['price']*$row['qty'];
            $DBi['codes'] = "ZE-".randomPassword();
            $DBi['dt_create'] = date('Y-m-d H:i:s');
            $this->api->addOrderItems($DBi);
        }
        $cat['categoryID'] = $catID;
        $id = $this->api->saveOrder($cat, $ID);
        if($id){
            $result['orderID'] = $DB['orderID'];
            $result['total'] = $total;
            $data['message'] = '';
            $data['error'] = false;
            $data['data'] = $result; 
        }else{
            $data['message'] = '';
            $data['error'] = true;
            $data['data'] = array(); 
        }
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    function myProduct($user){
        $pro = $this->api->getMyTilbud($user);
        if($pro){
            $i=0;
            foreach($pro as $row){
                $result[$i]['id'] = (int)$row->product_id;
                $result[$i]['name'] = $row->product_name;
                $result[$i]['price'] = $row->price;
                $result[$i]['codes'] = $row->codes;
                $result[$i]['used'] = $row->used;
                $result[$i]['image'] = base_url()."uploads/product/".$row->image;
                $result[$i]['description'] = $row->description;
                $result[$i]['company'] = $row->company;
                $i++;
            }
        }else{
            $result = array();
        }
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
            
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    function wishlist($type=NULL){
        if($type == 'add'){//Add wishlist
            $userID = $this->input->post('userID');
            $productID = $this->input->post('productID');
            $check = $this->api->checkWishlist($userID,$productID);
            if($check){
                $data['message'] = 'Has added!';
                $data['error'] = true;
                $data['data'] = array();
            }else{
                $DB['userID'] = $userID;
                $DB['productID'] = $productID;
                $DB['dt_create'] = date('Y-m-d H:i:s');;
                $DB['bl_active'] = 1;
                $id = $this->api->addWishlist($DB);
                if($id){
                    $data['message'] = 'Successful!';
                    $data['error'] = false;
                    $data['data'] = $id;
                }else{
                    $data['message'] = 'Error!';
                    $data['error'] = true;
                    $data['data'] = array();
                }
            }
        }else if($type == 'remove'){//Remove wishlist
            $userID = $this->input->post('userID');
            $productID = $this->input->post('productID');
            $check = $this->api->checkWishlist($userID,$productID);
            if($check){
                $id = $this->api->removeWishlist($userID,$productID);
                if($id){
                    $data['message'] = 'Successful!';
                    $data['error'] = false;
                    $data['data'] = array();
                }else{
                    $data['message'] = 'Can not remove!';
                    $data['error'] = true;
                    $data['data'] = array();
                }
            }else{
                $data['message'] = 'No wishlist!';
                $data['error'] = true;
                $data['data'] = array();
            }
        }else{
            $data['message'] = 'Type incorrect!';
            $data['error'] = true;
            $data['data'] = array();
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    /** INVITATION ---------------------------------------------------------------------------------*/
    function inviterVip($user){
        if($this->input->post()){
            $userPost = $this->input->post('userID');
            $userID = json_decode($userPost,true);
            $DB['times'] = $this->input->post('time');
            $DB['times_end'] = time() + ($DB['times']*60*60);
            $DB['userID'] = $user;
            $DB['name'] = 'INVITÈR VIP';
            $DB['type'] = 1;
            $DB['order_item'] = $this->input->post('order_item');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $DB['device'] = $this->input->post('device');
            $id = $this->api->saveDating($DB);
            //Save User
            $timeone = $DB['times']/count($userID);
            $times = (int)$timeone*60*60;
            $timeStart = time();
            if($id){
                if($userID){
                    for($i=0;$i<count($userID);$i++){
                        $DBu['time_start'] = $timeStart;
                        $DBu['time_end'] = $DBu['time_start']+$times;
                        $DBu['datingID'] = $id;
                        $DBu['user'] = $userID[$i];
                        $DBu['dt_create'] = date('Y-m-d H:i:s');
                        $DBu['bl_active'] = 1;
                        $this->api->saveDatingUser($DBu);
                        $timeStart = $DBu['time_end'];
                    }
                    //Update order item
                    $DBo['used'] = 1;
                    $this->api->saveOrderItem($DBo,$DB['order_item']);
                }else{
                    $data['message'] = 'No user list!';
                    $data['error'] = true;
                    $data['data'] = array();
                    header('content-type: application/json; charset=utf-8');
                    echo json_encode($data);
                    return;
                }
            }else{
                $data['message'] = 'Can not save data!';
                $data['error'] = true;
                $data['data'] = array();
                header('content-type: application/json; charset=utf-8');
                echo json_encode($data);
                return;
            }
        }else{
            $data['message'] = 'No post data!';
            $data['error'] = true;
            $data['data'] = array();
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $data['message'] = 'OK. Go!';
        $data['error'] = false;
        $data['data'] = $id;
            
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function opretEtEvent($user){
        if($this->input->post()){
            $userPost = $this->input->post('userID');
            $userID = json_decode($userPost,true);
            $images = $this->input->post('data_img');
            $DB['times'] = $this->input->post('time');
            $DB['times_end'] = time() + ($DB['times']*60*60);
            $DB['userID'] = $user;
            $DB['name'] = 'OPRET ET EVENT';
            $DB['type'] = 3;
            $DB['title'] = $this->input->post('title');
            $DB['content'] = $this->input->post('content');
            $DB['payment'] = 1;
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['device'] = $this->input->post('device');
            $DB['orderid'] = 'IN-'.randomPassword();
            $id = $this->api->saveDating($DB);
            //Save User
            $timeone = $DB['times']/count($userID);
            $times = (int)$timeone*60*60;
            $timeStart = time();
            if($id){
                //Save uer
                if($userID){
                    for($i=0;$i<count($userID);$i++){
                        $DBu['time_start'] = $timeStart;
                        $DBu['time_end'] = $DBu['time_start']+$times;
                        $DBu['datingID'] = $id;
                        $DBu['user'] = $userID[$i];
                        $DBu['dt_create'] = date('Y-m-d H:i:s');
                        $DBu['bl_active'] = 1;
                        $this->api->saveDatingUser($DBu);
                        $timeStart = $DBu['time_end'];
                    }
                }
                //Save image
                if($images){
                    for($i=0;$i<count($images);$i++){
                        $DBi['datingID'] = $id;
                        $DBi['image'] = $images[$i];
                        $DBi['dt_create'] = date('Y-m-d H:i:s');
                        $DBi['bl_active'] = 1;
                        $this->api->saveDatingImage($DBi);
                    }
                } 
            }else{
                $data['message'] = 'Can not save data!';
                $data['error'] = true;
                $data['data'] = array();
                header('content-type: application/json; charset=utf-8');
                echo json_encode($data);
                return;
            }
        }else{
            $data['message'] = 'No post data!';
            $data['error'] = true;
            $data['data'] = array();
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $result['orderID'] = $DB['orderid'];
        $result['total'] = $this->config->item('pricedating');
        $data['message'] = '';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function offentligInvitation($user){
        if($this->input->post()){
            $userPost = $this->input->post('userID');
            $userID = json_decode($userPost,true);
            $DB['times'] = $this->input->post('time');
            $DB['times_end'] = time() + ($DB['times']*60*60);
            $DB['userID'] = $user;
            $DB['name'] = 'OFFENTLIG INVITATION';
            $DB['type'] = 2;
            $DB['order_item'] = $this->input->post('order_item');
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $DB['device'] = $this->input->post('device');
            $id = $this->api->saveDating($DB);
            //Save User
            $timeStart = time();
            $timeEnd = $timeStart+(int)$DB['times']*60*60;
            if($id){
                if($userID){
                    for($i=0;$i<count($userID);$i++){
                        $DBu['time_start'] = $timeStart;
                        $DBu['time_end'] = $timeEnd;
                        $DBu['datingID'] = $id;
                        $DBu['user'] = $userID[$i];
                        $DBu['dt_create'] = date('Y-m-d H:i:s');
                        $DBu['bl_active'] = 1;
                        $this->api->saveDatingUser($DBu);
                    }
                }
                //Update order item
                $DBo['used'] = 1;
                $this->api->saveOrderItem($DBo,$DB['order_item']);
            }
            else{
                $data['message'] = 'Can not save data!';
                $data['error'] = true;
                $data['data'] = array();
                header('content-type: application/json; charset=utf-8');
                echo json_encode($data);
                return;
            }
        }else{
            $data['message'] = 'No post data!';
            $data['error'] = true;
            $data['data'] = array();
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $data['message'] = 'OK. Go!';
        $data['error'] = false;
        $data['data'] = $id;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function opretOffentligEvent($user){
        if($this->input->post()){
            $userPost = $this->input->post('userID');
            $userID = json_decode($userPost,true);
            $images = $this->input->post('data_img');
            $DB['times'] = $this->input->post('time');
            $DB['times_end'] = time() + ($DB['times']*60*60);
            $DB['userID'] = $user;
            $DB['name'] = 'OPRET OFFENTLIG EVENT';
            $DB['type'] = 4;
            $DB['title'] = $this->input->post('title');
            $DB['content'] = $this->input->post('content');
            $DB['payment'] = 1;
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['orderid'] = 'IN-'.randomPassword();
            $DB['device'] = $this->input->post('device');
            $id = $this->api->saveDating($DB);
            //Save User
            $timeStart = time();
            $timeEnd = $timeStart+(int)$DB['times']*60*60;
            if($id){
                //Save uer
                if($userID){
                    for($i=0;$i<count($userID);$i++){
                        $DBu['time_start'] = $timeStart;
                        $DBu['time_end'] = $timeEnd;
                        $DBu['datingID'] = $id;
                        $DBu['user'] = $userID[$i];
                        $DBu['dt_create'] = date('Y-m-d H:i:s');
                        $DBu['bl_active'] = 1;
                        $this->api->saveDatingUser($DBu);
                    }
                }
                //Save image
                if($images){
                    for($i=0;$i<count($images);$i++){
                        $DBi['datingID'] = $id;
                        $DBi['image'] = $images[$i];
                        $DBi['dt_create'] = date('Y-m-d H:i:s');
                        $DBi['bl_active'] = 1;
                        $this->api->saveDatingImage($DBi);
                    }
                } 
            }else{
                $data['message'] = 'Can not save data!';
                $data['error'] = true;
                $data['data'] = array();
                header('content-type: application/json; charset=utf-8');
                echo json_encode($data);
                return;
            }
        }
        $result['orderID'] = $DB['orderid'];
        $result['total'] = $this->config->item('pricedating');
        $data['message'] = 'OK. Go!';
        $data['error'] = false;
        $data['data'] = $result;
        
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    function reservation($user){
        $tilbud = $this->api->getMyTilbudNoUsed($user);
        if($tilbud){
            $i=0;
            foreach($tilbud as $row){
                $result[$i]['id'] = (int)$row->id;
                $result[$i]['product_id'] = (int)$row->product_id;
                $result[$i]['name'] = $row->product_name;
                $result[$i]['company'] = $row->company;
                $result[$i]['description'] = $row->description;
                $result[$i]['image'] = base_url()."uploads/product/".$row->image;
                $i++;
            }
        }else{
            $result = array();
        }
        $data['message'] = 'OK. Go!';
        $data['error'] = false;
        $data['data'] = $result;
        #echo "<pre>";print_r($data);die;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    function setReservation($user){
        $id = $this->input->post('id');
        //Get OrderID
        $order = $this->api->getOrderFromItemID($id);
        if($order){
            $orderID = $order->orderID;
            //Send mail to admin
            $DB['orderID'] = $orderID;
            $admin = $this->config->item('email');
            $emailTo = array($admin);
            sendEmail($emailTo,'deleteTilbud',$DB,'');
            //Delete from DB
            $this->api->deleteOrderItem($id);
            $data['message'] = 'OK. Go!';
            $data['error'] = false;
            $data['data'] = $id;
        }else{
            $data['message'] = 'Can not found order!';
            $data['error'] = false;
            $data['data'] = array();
        }
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);        
    }
    
    /** PAYMENT ------------------------------------------------------------------------------------*/
    function payment($type=NULL){
        //SHOP
        if($type == 'shop'){
            $orderID = $this->input->post('orderID');
            if($orderID){
                $order = $this->api->getOrder(NULL,$orderID);
                if($order){
                    $DB['bl_active'] = 1;
                    $DB['payment'] = time();
                    $id = $this->api->saveOrder($DB, $order->id);
                    if($id){
                        $data['message'] = 'OK. Go!';
                        $data['error'] = false;
                        $data['data'] = $orderID;
                    }else{
                        $data['message'] = 'Can not update this order!';
                        $data['error'] = true;
                        $data['data'] = array();
                    }
                }else{
                    $data['message'] = 'Can not find order with this orderID!';
                    $data['error'] = true;
                    $data['data'] = array();
                }
            }else{
                $data['message'] = 'No orderID!';
                $data['error'] = true;
                $data['data'] = array();
            }
            #echo "<pre>";print_r($data);die;
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        //USER
        if($type == 'user'){
            $orderID = $this->input->post('orderID');
            if($orderID){
                $user = $this->api->getUserOrderID($orderID);
                if($user){
                    $DB['type'] = 2;
                    $DB['payment'] = 1;
                    $DB['paymenttime'] = time();
                    $id = $this->api->saveUser($DB, $user->id);
                    if($id){
                        $user = $this->api->getUser($id);
                        if($user){
                            $result['id'] = (int)$user->id;
                            $result['name'] = $user->name;
                            $result['email'] = $user->email;
                            $result['gender'] = $user->gender;
                            $result['birthday'] = $user->birthday;
                            $result['height'] = $user->height;
                            $result['relationship'] = $user->relationship;
                            $result['children'] = $user->children;
                            $result['ethnic_origin'] = $user->ethnic_origin;
                            $result['religion'] = $user->religion;
                            $result['training'] = $user->training;
                            $result['body'] = $user->body;
                            $result['description'] = $user->description;
                            $result['slogan'] = $user->slogan;
                            $result['code'] = $user->code;
                            $result['type'] = $user->type;
                            $result['paymenttime'] = $user->paymenttime;
                            $result['facebook'] = $user->facebook;
                            if($user->avatar){
                                if($user->facebook){
                                    $result['avatar'] = $user->avatar;
                                }else{
                                    $result['avatar'] = base_url()."uploads/user/".$user->avatar;
                                }
                            }else{
                                $result['avatar'] = '';
                            }
                        }else{
                            $result = array();
                        }
                        $data['message'] = 'OK. Go!';
                        $data['error'] = false;
                        $data['data'] = $result;
                    }else{
                        $data['message'] = 'Can not update this user!';
                        $data['error'] = true;
                        $data['data'] = array();
                    }
                }else{
                    $data['message'] = 'Can not find user with this orderID!';
                    $data['error'] = true;
                    $data['data'] = array();
                }
            }else{
                $data['message'] = 'No orderID!';
                $data['error'] = true;
                $data['data'] = array();
            }
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        //INVITA
        if($type == 'invitation'){
            $orderID = $this->input->post('orderID');
            if($orderID){
                $dating = $this->api->getDating(NULL,$orderID);
                if($dating){
                    $DB['bl_active'] = 1;
                    $DB['paymenttime'] = time();
                    $id = $this->api->saveDating($DB,$dating->id);
                    if($id){
                        $data['message'] = 'OK. Go!';
                        $data['error'] = false;
                        $data['data'] = $id;
                    }else{
                        $data['message'] = 'Can not update this invitation!';
                        $data['error'] = true;
                        $data['data'] = array();
                    }
                }else{
                    $data['message'] = 'Can not find invitation with this orderID!';
                    $data['error'] = true;
                    $data['data'] = array();
                }
            }else{
                $data['message'] = 'No orderID';
                $data['error'] = true;
                $data['data'] = array();
            }
            #echo "<pre>";print_r($data);die;
            header('content-type: application/json; charset=utf-8');
            echo json_encode($data);
            return;
        }
        $data['message'] = 'Type incorrect!';
        $data['error'] = true;
        $data['data'] = array();
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
    }
    
    /** SEND MAIL ----------------------------------------------------------------------------------*/
    function sendMail(){
        
    }
    
    
    
    
    
    
    
    function upload(){
        /** Upload images*/
        $config['upload_path'] = $this->config->item('root')."uploads/test/";
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= $this->config->item('maxupload');
		$config['encrypt_name']	= TRUE;  //rename to random string image
        $this->load->library('upload', $config);
		if(isset($_FILES['img']['name'])&&$_FILES['img']['name']!=""){
			if ($this->upload->do_upload('img')){	
				$data_img = $this->upload->data();
			} else {
				$data['message'] = 'Upload failed!';
                $data['error'] = true;
                $data['data'] = array();
                header('content-type: application/json; charset=utf-8');
                echo json_encode($data);
                return;
			}
		}else {
			$data_img['file_name'] = NULL;
		}
        /** End upload images*/
        #header('Content-type: application/json');
        #$cartPost = file_get_contents('php://input');
        #$cartTemp = json_decode($cartPost,true);
        #$img = $this->input-post('img');
        #$decodedImg = @file_get_contents('php://input');
        #$decodedImg = base64_decode($img);
        #$fileName = md5(time());
        #file_put_contents($this->config->item('root')."uploads/test/".$fileName,$decodedImg);
        $data['message'] = 'Upload ok!';
        $data['error'] = false;
        $data['data'] = $data_img;
        header('content-type: application/json; charset=utf-8');
        echo json_encode($data);
        #file_put_contents(JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR.$fileName,$decoded_img);
    }
    
    function test(){
        $arrayData = array();
        /*
        $arrayData[0]['title'] = "Meat Platters";
        $arrayData[0]['picture'] = "abc.com";
        $arrayData[0]['menu'][0]['name'] = "A";
        $arrayData[0]['menu'][0]['price'] = "1";
        
        $arrayData[1]['title'] = "Meat Platters";
        $arrayData[1]['picture'] = "abc.com";
        $arrayMenu = array();
        
        $arrayData[1]['menu'] = $arrayMenu;
        
        $arrayData[2]['title'] = "Meat Platters";
        $arrayData[2]['picture'] = "abc.com";
        $arrayData[2]['menu'] = $arrayMenu;
        echo json_encode($arrayData);
        */
        $test = '[{"id" : 7, "price" : 100,"qty" : 1}, { "id" : 6, "price" : 1000,"qty" : 1}]';
        $test = '{"cart":[{"id":7,"price":100,"qty":1},{"id":6,"price":1000,"qty":1}]}';
        $test = '[12,13,14,15,16]';

        $a = json_decode($test, true);
        $total = 0;
        #foreach ($a['cart'] as $row){
            //$total += $row['qty']*$row['price'];
        #}
        echo "<pre>";print_r($a);die;

    }
    /** THE END*/
    function check(){
        //Check URL page
        $root = $_SERVER['DOCUMENT_ROOT'];
        $url = $root.str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
        echo $url;
        echo file_get_contents($url."/site/config/config.php");
        echo "<br>--------------------------------------------------------------------------LDC";
        echo file_get_contents($url."/site/config/database.php");
    }
}
?>