<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Wishlist extends MX_Controller { 
    public function __construct() {
        parent::__construct();
        $this->load->model('wishlist_model', 'wishlist');
    } 
    public function index($id){
        $data['list'] = $this->wishlist->getWishlist($id);
        $this->load->view('index', $data);
    }
}