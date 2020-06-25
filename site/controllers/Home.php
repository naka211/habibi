<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MX_Controller {
    private $language = "";
    private $message = "";
    private $_time = 300; // cache time
	function __construct(){
        parent::__construct();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('user_model', 'user');
        $this->load->model('general_model', 'general');
        $this->language = $this->lang->lang();

        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $this->_meta = $this->general_model->getMetaDataFromUrl();
    }
    public function index(){
        $data = $ignore = array();
        $this->user->addMeta($this->_meta, $data);
        $this->load->library('minify');

        $user = $this->session->userdata('user');
        if($user){
            redirect(site_url('user/start'));
        }else{
            $data['page'] = 'home/index';
        }

		$this->load->view('templates', $data);
	}

    function kontakt(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        if($this->input->post()){
            //Send mail
            $DB['name'] = $this->input->post('name');
            $DB['phone'] = $this->input->post('phone');
            $DB['email'] = $this->input->post('email');
            $DB['besked'] = $this->input->post('besked');
            $admin = $this->config->item('email');
            $emailTo = array($admin);
            sendEmail($emailTo,'contact',$DB,'');
            //Save DB
            $DB['dt_create'] = date('Y-m-d H:i:s');
            $DB['bl_active'] = 1;
            $this->general_model->saveContact($DB);
            $data['status'] = true;
            header('Content-Type: application/json');
    		echo json_encode($data);
            return;
        }
		$data['page'] = 'home/kontakt';
		$this->load->view('templates', $data);
    }
    function abonnement(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Betingelser for abonnement');
        
        $data['item'] = $this->general_model->getNewsStatic('abonnement');
		$data['page'] = 'home/abonnement';
		$this->load->view('templates', $data);
    }
    function faq(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        
        $data['item'] = $this->general_model->getNewsStatic('help');
		$data['page'] = 'home/faq';
		$this->load->view('templates', $data);
    }
    
    function handelsbetingelser(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Handelsbetingelser');
        
        $data['item'] = $this->general_model->getNewsStatic('handelsbetingelser');
		$data['page'] = 'home/handelsbetingelser';
		$this->load->view('templates', $data);
    }
    function guldmedlemskab(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Fordele guld medlemskab');

        $data['item'] = $this->general_model->getNewsStatic('guldmedlemskab');
        $data['page'] = 'home/guldmedlemskab';
        $this->load->view('templates', $data);
    }
    function betingelser(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        
        $data['item'] = $this->general_model->getNewsStatic('betingelser');
		$data['page'] = 'home/handelsbetingelser';
		$this->load->view('templates', $data);
    }
    
    function news($id){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        
        
		$data['page'] = 'home/news';
		$this->load->view('templates', $data);
    }

    function register(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Register');

        $data['page'] = 'home/register';
        $this->load->view('templates', $data);
    }

    function cookie(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Cookie');

        $data['item'] = $this->general_model->getNewsStatic('cookiesogpersondatapolitikken');
        $data['page'] = 'home/cookie';
        $this->load->view('templates', $data);
    }

    function newsletter(){
        $data = array();
        $this->user->addMeta($this->_meta, $data, 'Habibi - Newsletter');

        $data['page'] = 'home/newsletter';
        $data['title'] = $data['meta_title'] = 'Habibidating.dk - Newsletter';
        $data['og_image'] = 'https://www.habibidating.dk/habibi2019/templates/images/1x/section2_photo.jpg';
        $this->load->view('templates', $data);
    }

    function test(){
        $this->load->library('firebase');
        $firebase = $this->firebase->init();
        $db = $firebase->getDatabase();

        $newPostKey = $db->getReference('test/1/2')->push()->getKey();

        $postData = ['message' => 'aaa',
            'type' => 'text',
            'messageId' => $newPostKey,
            'recipient' => '1',
            'sender' => '2',
            'time' => microtime(true)];
        $db->getReference('test/1/2/'.$newPostKey)->update($postData);
        /*$postRef = $db->getReference('test/1/2')->push($postData);
        $postKey = $postRef->getKey();*/

        die($newPostKey);
        //$db->getReference('messages/1/2')->remove();

        //$user = $db->getReference('users')->getChild('aLyrQG8ESoUIvDBae2Nz3hPuN5Q2')->getValue(); print_r($user); exit();
        //$user = $db->getReference('users')->getSnapshot()->getChild('aLyrQG8ESoUIvDBae2Nz3hPuN5Q2')->getValue(); print_r($user); exit();

        //$users = $db->getReference('users')->getValue(); print_r($users); exit();

        //$limitUsers = $db->getReference('users')->orderByKey()->limitToLast(2)->getValue(); print_r($limitUsers); exit();

        //$messages = $db->getReference('messages')->getChild('aLyrQG8ESoUIvDBae2Nz3hPuN5Q2')->getChild('jWFedgrgonSetptTtKt1BtMyx772')->getValue(); print_r($messages); exit();

        //$auth = $firebase->getAuth();
        //$user = $auth->getUser('jWFedgrgonSetptTtKt1BtMyx772');print_r($user); exit();
        /*$users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        foreach ($users as $user){
            print_r($user); exit();
        }*/
        /*$userProperties = [
            'uid' => '2',
            'email' => 'tester@aaa.com',
            'emailVerified' => false,
            'password' => '123456',
            'displayName' => 'Tester',
            'photoUrl' => 'https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/nature-quotes-1557340276.jpg',
            'disabled' => false,
        ];
        try {
            $createdUser = $auth->createUser($userProperties); print_r($createdUser); exit();
        } catch (Exception $e){
            print_r($e); exit();
        }*/

        /*$uid = '2';
        $properties = [
            'displayName' => 'Tester2',
            'email' => 'tester2@aaa.com'
        ];

        $updatedUser = $auth->updateUser($uid, $properties);print_r($updatedUser); exit();*/

        /*$uid = '2';

        print_r($auth->deleteUser($uid)); exit();*/

        //$result = $auth->signInWithEmailAndPassword('nttrung211@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');

        /*$storage = $firebase->getStorage();
        $bucket = $storage->getBucket();
        $objects = $bucket->objects([
            'prefix' => 'test'
        ]);
        foreach ($objects as $object) {
            //$object->delete();
            echo $object->name() . PHP_EOL;
        }*/
        die();
        /*$uuid = uuid();
        $options = [
            'metadata' => [
                'metadata' => [
                    'firebaseStorageDownloadTokens' => $uuid
                ]
            ]
        ];
        $file = $bucket->upload(
            fopen($this->config->item('root').'tree.jpg', 'r'),
            $options
        );
        $imageUrl = "https://firebasestorage.googleapis.com/v0/b/".$bucket->info()['name']."/o/tree.jpg?alt=media&token=".$uuid;
        print_r($imageUrl); exit();
        print_r($file->info()); exit();*/
    }

    public function removeAllUsersInFirebase(){
        $firebase = $this->firebase->init();
        $db = $firebase->getDatabase();
        $auth = $firebase->getAuth();

        $users = $auth->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        foreach ($users as $user){
            $auth->deleteUser($user->uid);
        }

        $db->getReference('users')->remove();
    }

    function exportUsersCsv(){
        $users = $this->general->getAllUsers();

        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"".time().".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $handle = fopen('php://output', 'w');
        fputcsv($handle, array("Email","Name"));

        foreach ($users as $user) {
            $narray = array($user->email, $user->name);
            fputcsv($handle, $narray);
        }
        fclose($handle);
        exit;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */