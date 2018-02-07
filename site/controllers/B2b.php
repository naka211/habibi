<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class B2b extends MX_Controller{
	function __construct(){
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->language = $this->lang->lang();

        //Get meta data from url
        $this->_meta = $this->general_model->getMetaDataFromUrl();
	}

    protected function middleware(){
        return array('Checklogin|only:profile,sold');
    }

	function index(){

	}

	public function sold($page = 0){
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

    public function profile(){
        $user = $this->session->userdata('user');
        $data['info'] = $this->user->getB2b($user->id);

        $data['page'] = 'user/b2b_profile';
        $this->load->view('templates', $data);
    }

    public function update(){
        $user = $this->session->userdata('user');
        $DB['name']     = $this->input->post('name');
        $DB['email']    = $this->input->post('email');
        $DB['company']  = $this->input->post('company');
        $DB['code']     = $this->input->post('code');
        $DB['address']  = $this->input->post('address');
        $DB['link']     = $this->input->post('link');
        $DB['dt_update']= date('Y-m-d H:i:s');
        if ($this->input->post('password') && $this->input->post('repassword')) {
            if ($this->input->post('password') != $this->input->post('repassword')) {
                $this->session->set_flashdata('message', "Genadgangskode er forkert");
                redirect(site_url('b2b/profile'));
            } else {
                $DB['password'] = md5($this->input->post('password'));
            }
        }

        $result = $this->user->updateB2B($DB, $user->id);
        if($result){
            //Update information in session
            $b2b = $this->user->getB2b($user->id);
            $b2b->b2b = true;
            $this->session->set_userdata('user', $b2b);
            //redirect
            $this->session->set_flashdata('message', "Opdater succesfuldt");
            redirect(site_url('b2b/profile'));
        }
    }
}
?>