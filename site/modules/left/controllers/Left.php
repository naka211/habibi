<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Left extends MX_Controller { 
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
    } 
    public function index($id){
        $data['item'] = $this->user->getUser($id);
        $data['photo'] = $this->user->getPhoto($id, 2, $data['item']->avatar);
        $data['numphoto'] = $this->user->getNumPhoto($id);
        $data['numinvitajoin'] = count($this->user->getDatingByUser($id));
        $data['numinvitaapproved'] = count($this->user->getDatingApproved($id));
        $data['numUnreadMessage'] = $this->user->getNumUnreadMessage($id);
        $this->load->view('index', $data);
    }

    public function avatar($user, $width, $height){
        $data['user'] = $user;
        $data['width'] = $width;
        $data['height'] = $height;
        $this->load->view('avatar', $data);
    }
}