<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MX_Controller {
    private $language = "";
    private $message = "";
    private $_time = 300; // cache time
	function __construct(){
        parent::__construct();
        $this->session->set_userdata(array('url'=>uri_string()));
        $this->load->model('user_model', 'user');
        $this->load->model('tilbud_model','tilbud');
        $this->language = $this->lang->lang();

        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $this->_meta = $this->general_model->getMetaDataFromUrl();
    }
    public function index(){
        $data = $ignore = array();
        $this->user->addMeta($this->_meta, $data);

        $user = $this->session->userdata('user');
        if($user){
            $data['page'] = 'home/home';
        }else{
            $data['page'] = 'home/index';
        }

        if($user){
            $ignore[] = $user->id;
        }

        //if ( ! $randomUsers = $this->cache->get('randomUsers')){
            $randomUsers = $this->user->getList(4, 0, null, $ignore, null, 'random');
            //$this->cache->save('randomUsers', $randomUsers, $this->_time);
        //}

        //if ( ! $newestUsers = $this->cache->get('newestUsers')){
            $newestUsers = $this->user->getList(10, 0, null, $ignore, null, 'newest');
        //$this->cache->save('newestUsers', $newestUsers, $this->_time);
        //}

        //if ( ! $popularUsers = $this->cache->get('popularUsers')){
            $popularUsers = $this->user->getList(10, 0, null, $ignore, null, 'popular');
        //$this->cache->save('popularUsers', $popularUsers, $this->_time);
        //}

        $data['randomUsers'] = $randomUsers;
        $data['newestUsers'] = $newestUsers;
        $data['popularUsers'] = $popularUsers;
        $data['user'] = $user;
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
    function om(){
        $data = array();
        $this->user->addMeta($this->_meta, $data);
        
        $data['item'] = $this->general_model->getNewsStatic('omzeeduce');
		$data['page'] = 'home/om';
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
        $this->user->addMeta($this->_meta, $data);
        
        $data['item'] = $this->general_model->getNewsStatic('handelsbetingelser');
		$data['page'] = 'home/handelsbetingelser';
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */