<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Myphoto extends MX_Controller { 
    public function __construct() {
        parent::__construct();
        $this->load->model('myphoto_model', 'myphoto');
    } 
    public function index($user){
        $data['list'] = $this->myphoto->getPhoto($user);
        $this->load->view('index', $data);
    }
}