<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Myphoto_Model extends MX_Controller { 
    public function __construct() {
        parent::__construct(); 
    }
    function getPhoto($userId = NULL, $type = 1, $avatar = ''){
        $this->db->select('*')->from('user_image');
        if($userId){
            $this->db->where("userID",$userId);
        }
        $this->db->where("type",$type);
        if($avatar != ''){
            $this->db->where('image != ',$avatar);
        }
        $query = $this->db->get()->result();
        return $query;
    }
}